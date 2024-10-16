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

    public function writeLog($message, $logFileName = "exception.log")
    {
        try {
            $logDirectory = __DIR__ . "/../../logs/";

            $this->ensureLogDirectoryExists($logDirectory);

            $logFile = $logDirectory . $logFileName;

            $output = $this->formatMessage($message);

            error_log($output, 3, $logFile);
        } catch (\Throwable $e) {
            // Not really much to do here.
        }
    }

    private function ensureLogDirectoryExists($logDirectory)
    {
        if (!is_dir($logDirectory)) {
            mkdir($logDirectory);
        }
    }

    private function formatMessage($message)
    {
        $timeStamp = date("H-i-s");
        return "[$timeStamp]: $message";
    }
}
