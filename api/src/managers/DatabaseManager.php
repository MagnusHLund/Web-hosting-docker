<?php

namespace MagZilla\Api\Managers;

use MagZilla\Api\Utils\Constants;
use Illuminate\Database\Capsule\Manager as Capsule;

use Illuminate\Support\Facades\DB;
use MagZilla\Api\Models\OrmModelMapper;

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
            self::$instance = new DatabaseManager();
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
        } catch (\PDOException $e) {
        }
    }

    public function read($model, array $conditions, array $columns = null, int $limit = null)
    {
        try {
            $query = $model::where($conditions);

            if (isset($columns)) {
                $query->select($columns);
            }

            if (isset($limit)) {
                $query->take($limit);
            }

            $result = $query->get();

            return $result->toArray();
        } catch (\PDOException $e) {
        }
    }

    public function update($model, int $id, array $data, $columnsToReturn = [])
    {
        try {
            $table = $model->getTable();
            $primaryKey = $model->getKeyName();

            $this->capsule::table($table)->where($primaryKey, $id)->update($data);

            if (!empty($columnsToReturn)) {
                $this->capsule::table($table)->where($primaryKey, $id)->select($columnsToReturn)->first();
            }
        } catch (\PDOException $e) {
        }
    }

    public function delete($model, array $conditions)
    {
        try {
            $deletedRows = $model::where($conditions)->delete();

            if (empty($deletedRows)) {
                throw new \PDOException();
            }

            return $deletedRows;
        } catch (\PDOException $e) {
        }
    }
}
