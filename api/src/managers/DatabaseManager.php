<?php

namespace MagZilla\Api\Managers;

use MagZilla\Api\Utils\Constants;
use Illuminate\Database\Capsule\Manager as Capsule;

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

    public function create($model, $data, $returnColumns = [])
    {
        try {
            return $model::create($data);
        } catch (\PDOException $e) {
        }
    }

    public function read($model, $conditions, array $columns = null, $limit = null)
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

    public function update($model, $conditions, $data, $returnColumns = [])
    {
        try {
            return $model::where($conditions)->update($data);
        } catch (\PDOException $e) {
        }
    }

    public function delete($model, $conditions)
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
