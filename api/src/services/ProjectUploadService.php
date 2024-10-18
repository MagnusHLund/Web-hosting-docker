<?php

namespace MagZilla\Api\Services;

use MagZilla\Api\Utils\Constants;

class ProjectUploadService
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

    public function extractZipFile($directory) {}

    public function extractDotEnv($directory) {}

    public function extractGitClone($directory, $gitUrl) {}

    public function getServiceDirectory($serviceOwner, $serviceName, $additionalPath = null)
    {
        $basePath = Constants::getBaseServicePath();
        return "$basePath/$serviceOwner/$serviceName/$additionalPath";
    }
}
