<?php

namespace MagZilla\Api\Services;

class ProjectUploadService
{
    private static $instance = null;

    private function __construct() {}

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ProjectUploadService();
        }
        return self::$instance;
    }

    public function extractZipFile($directory) {}

    public function extractDotEnv($directory) {}

    public function extractGitClone($directory, $gitUrl) {}
}
