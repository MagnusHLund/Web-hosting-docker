<?php

namespace MagZilla\Api\Managers;

class Logger
{
    private static $instance = null;

    private function __construct() {}

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function writeLog(\Exception $exception, $logFileName = "exception.log")
    {
        try {
            $logDirectory = __DIR__ . "/../../logs/";

            $this->ensureLogDirectoryExists($logDirectory);

            $logFile = $logDirectory . $logFileName;

            $sanitizedMessage = $this->sanitizeLogMessage($exception);
            $output = $this->formatMessage($sanitizedMessage);

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

    private function sanitizeLogMessage(\Exception $exception)
    {
        $stackTrace = $exception->getTraceAsString();
        return preg_replace('/\'[^\']*\'/', '\'string\'', $stackTrace);
    }

    private function formatMessage($message)
    {
        $timeStamp = date("H-i-s");
        return "[$timeStamp]: $message";
    }
}
