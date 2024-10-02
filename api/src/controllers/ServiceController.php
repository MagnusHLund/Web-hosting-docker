<?php

namespace MagZilla\Api\Controllers;

use MagZilla\Api\Models\User;
use MagZilla\Api\Models\ServiceType;
use MagZilla\Api\Models\OrmModelMapper;
use MagZilla\Api\Services\ProjectUploadService;
use MagZilla\Api\Models\DTOs\Services\AddServiceRequest;

class ServiceController extends BaseController
{
    private ProjectUploadService $projectUploadService;

    public function __construct()
    {
        $this->projectUploadService = ProjectUploadService::getInstance();
    }

    public function addService($request)
    {
        try {
            $addServiceRequest = new AddServiceRequest($request);

            $user = User::getUserFromJwt(
                $this->cookieHandler,
                $this->securityManager
            );

            $isGitProject = isset($addServiceRequest->gitUrl);

            $serviceId = $this->database->create(
                OrmModelMapper::ServicesTable->getModel(),
                [
                    "service_owner_user_id" => $user->id,
                    "service_name"          => $addServiceRequest->serviceName,
                    "git_clone_url"         => $isGitProject ? $addServiceRequest->gitUrl : null,
                ],
                ["service_id"]
            );

            array_map(function (ServiceType $serviceType) use ($serviceId) {
                $this->database->create(
                    OrmModelMapper::ServiceTypesTable->getModel(),
                    [
                        "service_id"       => $serviceId,
                        "type"             => $serviceType->type,
                        "startup_location" => $serviceType->startupPath,
                        "env_location"     => $serviceType->dotEnvPath,
                        "port"             => $serviceType->port
                    ],
                    true
                );
            }, $addServiceRequest->serviceTypes);

            // TODO: Upload project via zip or git

            $projectDirectory = $this->projectUploadService->getServiceDirectory(
                $user->getName($this->database),
                $addServiceRequest->serviceName
            );

            if ($isGitProject) {
                $this->projectUploadService->extractGitClone(
                    $projectDirectory,
                    $addServiceRequest->gitUrl
                );
            } else {
                $this->projectUploadService->extractZipFile(
                    $projectDirectory
                );
            }

            array_map(function (ServiceType $serviceType) {
                if (isset($serviceType->dotEnvPath)) {
                    // TODO: Upload .env files
                }
            }, $addServiceRequest->serviceTypes);

            // TODO: Send response, which includes all data related to the new service and service types
            $this->handleSuccess();
        } catch (\exception $e) {
        }
    }

    public function deleteService() {}

    public function getServiceDetails() {}

    public function getServices() {}

    public function searchServices() {}

    public function updateService() {}

    public function updateServiceSource() {}
}
