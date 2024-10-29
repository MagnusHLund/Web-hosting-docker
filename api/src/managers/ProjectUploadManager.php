<?php

namespace MagZilla\Api\Managers;

use MagZilla\Api\Services\GitService;
use MagZilla\Api\Models\ServiceType;
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

    public function handleServiceUpload(User $user, DatabaseManager $database, string $serviceName, string $projectFiles, array $serviceTypes, bool $isGitProject)
    {
        $serviceDirectory = $this->calculateServiceDirectory($user, $database, $serviceName);

        $isGitProject ? $this->handleGitUpload($user, $database, $serviceName, $serviceDirectory, $projectFiles) :
            $this->handleProjectZipUpload($user, $database, $serviceName, $serviceDirectory, $projectFiles);

        array_map(function ($serviceType) use ($user, $database, $serviceName) {
            $dotEnvStartupDirectory = $this->calculateServiceDirectory($user, $database, $serviceName, $serviceType->dotEnvPath);
            $this->extractDotEnv($dotEnvStartupDirectory);

            $this->addServiceTypesToStartup($serviceType->startupPath, $serviceType->type, $serviceType->port);
        }, $serviceTypes);
    }

    private function handleGitUpload(User $user, DatabaseManager $database, string $serviceName, string $serviceDirectory, string $gitUrl)
    {
        $gitService = new GitService();
        $gitService->cloneGitRepository($gitUrl, $serviceDirectory);
    }

    private function handleProjectZipUpload(User $user, DatabaseManager $database, string $serviceName, string $serviceDirectory, string $files) {}

    public function extractProjectZipFile($directory) {}

    public function extractDotEnv($directory) {}

    public function calculateServiceDirectory(User $serviceOwner, DatabaseManager $database, string $serviceName, string $additionalPath = null)
    {
        $basePath = Constants::getBaseServiceDirectory();
        $serviceOwnerName = $serviceOwner->getName($database);

        return "$basePath/$serviceOwnerName/$serviceName/$additionalPath";
    }

    /**
     * Updates the projects.json file, which is read by the python script that starts the services.
     *
     * An example of how the json file looks:
     *  [
     *      {
     *          "path": "/app/src/root/MagZilla/web/",
     *          "type": "react",
     *          "port": "3000"
     *      },
     *  ]
     */
    private function addServiceTypesToStartup($path, $type, $port) {}
}
