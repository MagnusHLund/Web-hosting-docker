<?php

namespace MagZilla\Api\Handlers;

class LogHandler
{
    private static $instance = null;

    private function __construct() {}

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new LogHandler();
        }
        return self::$instance;
    }

    public function writeLog($message)
    {
        $logDirectory = __DIR__ . "./../../logs/";

        $date = date("Y-m-d");
        $fileName = "exception-$date.log";
        $logFile = $logDirectory . $fileName;

        $timeStamp = date("H-i-s");

        $output = "[$timeStamp]: $message";

        error_log($output, 3, $logFile);
    }
}
