<?php

namespace MagZilla\Managers;

use MagZilla\Utils\Constants;
use Illuminate\Database\Capsule\Manager as Capsule;

class Database
{
    private static $instance = null;
    private $capsule;

    private function __construct()
    {
        $constants = Constants::getInstance();
        $databaseInfo = $constants->GetDatabaseInfo();

        $this->capsule = new Capsule();

        $this->capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => $databaseInfo["DB_HOST"],
            'database'  => $databaseInfo["DB_DATABASE"],
            'username'  => $databaseInfo["DB_USER"],
            'password'  => $databaseInfo["DB_PASSWORD"],
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
            self::$instance = new Database();
        }
        return self::$instance;
    }


    public function create($model, $data)
    {
        try {
            $modelClass = ModelMapper::getModelClass($model);
            return $modelClass::create($data);
        } catch (\PDOException $e) {
            $stringifiedData = json_encode($data);
            $attemptedOperation = "Table: $model, Data: $stringifiedData";

            $this->handlePdoException($e, $attemptedOperation);
        }
    }

    /**
     * @param string $model is the ORM model that is being used to read from the database.
     * @param array $conditions is responsible for returning only rows that match all conditions in the array.
     *              Example: ['first_column' => 1, 'second_column' => 'string']
     * @param string|array|null $columns handles which columns should be returned. Set to null to return all columns in the table.
     *              Example 1: 'first_column'.
     *              Example 2: ['first_column', 'second_column']
     * @param int $limit is the maximum rows to return.
     * @param int $rowsToSkip filters out the first X amount of rows and returns those not filtered out.
     * @param boolean $random returns the rows in a random order.
     */
    public function read($model, $conditions, $columns = null, $limit = null, $rowsToSkip = null, $random = false)
    {
        try {
            $modelClass = ModelMapper::getModelClass($model);
            $query = $modelClass::where($conditions);

            if ($columns) {
                $query->select(is_array($columns) ? $columns : [$columns]);
            }

            if ($random) {
                $query = $query->inRandomOrder();
            }

            if ($rowsToSkip) {
                $query = $query->skip($rowsToSkip);
            }

            if ($limit) {
                $query = $query->take($limit);
            }

            $result = $query->get();

            if ($result) {
                return $result->toArray();
            }
        } catch (\PDOException $e) {
            $stringifiedColumns = json_encode($columns);
            $stringifiedConditions = json_encode($conditions);
            $attemptedOperation = "Table: $model, Columns: $stringifiedColumns, Conditions: $stringifiedConditions";

            $this->handlePdoException($e, $attemptedOperation);
        }
    }

    public function update($model, $conditions, $data)
    {
        try {
            $modelClass = ModelMapper::getModelClass($model);
            return $modelClass::where($conditions)->update($data);
        } catch (\PDOException $e) {
            $stringifiedData = json_encode($data);
            $stringifiedConditions = json_encode($conditions);
            $attemptedOperation = "Table: $model, Data: $stringifiedData, Conditions: $stringifiedConditions";

            $this->handlePdoException($e, $attemptedOperation);
        }
    }

    public function delete($model, $conditions)
    {
        try {
            $modelClass = ModelMapper::getModelClass($model);
            $deletedRows = $modelClass::where($conditions)->delete();

            if ($deletedRows === 0) {
                throw new \PDOException("Attempted delete on non-existent row", 45001);
            }

            return $deletedRows;
        } catch (\PDOException $e) {
            $stringifiedConditions = json_encode($conditions);
            $attemptedOperation = "Table: $model, Conditions: $stringifiedConditions";

            $this->handlePdoException($e, $attemptedOperation);
        }
    }
}
