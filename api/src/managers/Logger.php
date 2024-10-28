<?php

namespace MagZilla\Api\Managers;

class Logger
{
    private static $instance = null;
    private const LOG_DIRECTORY = __DIR__ . "/../../logs/";

    private function __construct()
    {
        $this->ensureLogDirectoryExists();
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function writeExceptionLog(\Exception $exception)
    {
        $logFile = self::LOG_DIRECTORY . "/exception.log";

        $sanitizedMessage = $this->sanitizeLogMessage($exception);
        $output = $this->formatMessage($sanitizedMessage);

        $this->writeLog($output, $logFile);
    }

    public function writeSystemLog($message)
    {
        $logFile = self::LOG_DIRECTORY . "/system.log";
        $output = $this->formatMessage($message);
        $this->writeLog($output, $logFile);
    }

    private function writeLog($output, $logFile)
    {
        try {
            error_log($output, 3, $logFile);
        } catch (\Throwable $e) {
            // Not really much to do here.
        }
    }

    private function ensureLogDirectoryExists()
    {
        if (!is_dir(self::LOG_DIRECTORY)) {
            mkdir(self::LOG_DIRECTORY);
        }
    }

    private function sanitizeLogMessage(\Exception $exception)
    {
        $stackTrace = $exception->getTraceAsString();
        return preg_replace('/\'[^\']*\'/', '\'string\'', $stackTrace);
    }

    private function formatMessage($message)
    {
        $timeStamp = date("H:i:s");
        return "[$timeStamp]: $message\n";
    }
}
