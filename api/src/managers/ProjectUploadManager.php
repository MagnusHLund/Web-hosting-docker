<?php

namespace MagZilla\Api\Managers;

use Directory;
use MagZilla\Api\Helpers\GitService;
use MagZilla\Api\Models\FileUpload;
use MagZilla\Api\Models\User;
use MagZilla\Api\Utils\Constants;

class ProjectUploadManager
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

    public function handleServiceUpload(User $user, DatabaseManager $database, string $serviceName, string $projectFiles, $isGitProject) {}

    private function handleGitUpload(User $user, DatabaseManager $database, string $serviceName, string $gitUrl)
    {
        $serviceDirectory = $this->getServiceDirectory($user, $database, $serviceName);
        $this->extractGitClone($gitUrl, $serviceDirectory);
    }

    private function handleZipUpload(User $user, DatabaseManager $database, string $serviceName, string $file) {}

    public function extractZipFile($directory) {}

    public function extractDotEnv($directory) {}

    private function extractGitClone($gitUrl, $directory)
    {
        $gitService = new GitService();
        $gitService->cloneGitRepository($gitUrl, $directory);
    }

    public function getServiceDirectory(User $serviceOwner, DatabaseManager $database, string $serviceName, string $additionalPath = null)
    {
        $serviceOwnerName = $serviceOwner->getName($database);

        $basePath = Constants::getBaseServiceDirectory();
        return "$basePath/$serviceOwnerName/$serviceName/$additionalPath";
    }
}
