<?php

namespace MagZilla\Api\Managers;

use MagZilla\Api\Utils\Constants;
use Illuminate\Database\Capsule\Manager as Capsule;
use MagZilla\Api\Models\Exceptions\ControllerException;
use MagZilla\Api\Models\OrmModelMapper;
use PDOException;

class DatabaseManager
{
    private static $instance = null;
    private $capsule;

    private function __construct()
    {
        $databaseInfo = Constants::GetDatabaseInfo();

        $this->capsule = new Capsule();

        $this->capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => $databaseInfo["DB_HOST"],
            'database'  => $databaseInfo["DB_NAME"],
            'username'  => $databaseInfo["DB_USER"],
            'password'  => $databaseInfo["DB_PASS"],
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);

        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function create(OrmModelMapper $modelEnum, array $data, $columnsToReturn = [])
    {
        try {

            $model = $modelEnum->getModel();

            if (empty($columnsToReturn)) {
                return $model::create($data);
            } else {
                $table = $model->getTable();
                $primaryKey = $model->getKeyName();

                $tableId = $this->capsule::table($table)->insertGetId($data);

                return $this->capsule::table($table)
                    ->where($primaryKey, $tableId)
                    ->select($columnsToReturn)
                    ->first();
            }
        } catch (PDOException $e) {
            $this->handlePDOException($e);
        }
    }

    public function read(OrmModelMapper $modelEnum, array $conditions, array $columns = null, int $limit = null)
    {
        try {
            $model = $modelEnum->getModel();
            $query = $model::where($conditions);

            if (isset($columns)) {
                $query->select($columns);
            }

            if (isset($limit)) {
                $query->take($limit);
            }

            $result = $query->get();

            return $result->toArray();
        } catch (PDOException $e) {
            $this->handlePDOException($e);
        }
    }

    public function readMultipleTables(array $modelEnums, array $columns = null, int $limit = null)
    {
        try {
            $models = array_map(fn($modelEnum) => $modelEnum->getModel(), $modelEnums);
            $mainModel = $models[0];
            $mainPrimaryKey = $mainModel->getKeyName();
            $mainTable = $mainModel->getTable();

            $query = $this->capsule::table($mainTable);

            foreach (array_slice($models, 1) as $model) {
                $query->join($model->getTable(), "$mainTable.$mainPrimaryKey", '=', "{$model->getTable()}.$mainPrimaryKey");
            }

            if (!empty($columns)) {
                if (!in_array($mainPrimaryKey, $columns)) {
                    $columns[] = "$mainTable.$mainPrimaryKey as $mainPrimaryKey";
                }
                $query->select($columns);
            } else {
                $query->select("$mainTable.*");
            }

            if (isset($limit)) {
                $query->take($limit);
            }

            return $query->get()->toArray();
        } catch (\Exception $e) {
            $this->handlePDOException($e);
        }
    }

    public function update(OrmModelMapper $modelEnum, array $conditions, array $data, $columnsToReturn = [])
    {
        try {
            $model = $modelEnum->getModel();
            $table = $model->getTable();

            $this->capsule::table($table)->where($conditions)->update($data);

            if (!empty($columnsToReturn)) {
                return $this->capsule::table($table)
                    ->where($conditions)
                    ->select($columnsToReturn)
                    ->first();
            }
        } catch (PDOException $e) {
            $this->handlePDOException($e);
        }
    }

    public function delete($model, array $conditions)
    {
        try {
            $deletedRows = $model::where($conditions)->delete();

            if (empty($deletedRows)) {
                throw new PDOException();
            }

            return $deletedRows;
        } catch (PDOException $e) {
            $this->handlePDOException($e);
        }
    }

    private function handlePDOException(PDOException $exception)
    {
        throw new ControllerException("An error occurred, while interacting with the database", 500, $exception);
    }
}
