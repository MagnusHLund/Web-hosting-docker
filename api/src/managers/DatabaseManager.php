<?php

namespace MagZilla\Api\Managers;

use MagZilla\Api\Utils\Constants;
use Illuminate\Database\Capsule\Manager as Capsule;

class Database
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
        } catch (\PDOException $e) {
        }
    }

    public function read($model, $conditions, $columns = null, $limit = null, $rowsToSkip = null)
    {
        try {
        } catch (\PDOException $e) {
        }
    }

    public function update($model, $conditions, $data)
    {
        try {
        } catch (\PDOException $e) {
        }
    }

    public function delete($model, $conditions)
    {
        try {
        } catch (\PDOException $e) {
        }
    }
}
