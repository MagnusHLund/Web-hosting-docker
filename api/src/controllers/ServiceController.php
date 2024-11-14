<?php

namespace MagZilla\Api\Controllers;

use MagZilla\Api\Models\User;
use MagZilla\Api\Models\Service;
use MagZilla\Api\Utils\TextUtils;
use MagZilla\Api\Models\ServiceType;
use MagZilla\Api\Models\OrmModelMapper;
use MagZilla\Api\Managers\ProjectUploadManager;
use MagZilla\Api\Models\DTOs\Users\updateServiceType;
use MagZilla\Api\Models\Exceptions\ControllerException;
use MagZilla\Api\Models\DTOs\Services\AddServiceRequest;
use MagZilla\Api\Models\DTOs\Services\DeleteServiceRequest;
use MagZilla\Api\Models\DTOs\Services\UpdateServiceRequest;
use MagZilla\Api\Models\DTOs\Services\GetServiceDetailsRequest;

class ServiceController extends BaseController
{
    private ProjectUploadManager $projectUploadManager;

    public function __construct()
    {
        parent::__construct();

        $this->projectUploadManager = ProjectUploadManager::getInstance();
    }

    public function addService($request)
    {
        try {
            $addServiceRequest = new AddServiceRequest($request);

            $user = User::getUserFromJwt(
                $this->cookieService,
                $this->securityManager
            );

            $isGitProject = TextUtils::isUrl($addServiceRequest->projectFiles);

            $serviceId = $this->database->create(
                OrmModelMapper::ServicesTable,
                [
                    "service_owner_user_id" => $user->id,
                    "service_name"          => $addServiceRequest->serviceName,
                    "git_clone_url"         => $isGitProject ? $addServiceRequest->projectFiles : null,
                ],
                ["service_id"]
            )->service_id;

            $serviceTypes = array_map(function (ServiceType $serviceType) use ($serviceId) {
                return $this->database->create(
                    OrmModelMapper::ServiceTypesTable,
                    [
                        "service_id"       => $serviceId,
                        "type"             => $serviceType->type,
                        "startup_location" => $serviceType->startupPath,
                        "env_location"     => $serviceType->dotEnvPath,
                        "port"             => $serviceType->port
                    ],
                    ["service_type_id", "type", "startup_location", "env_location", "port"]
                );
            }, $addServiceRequest->serviceTypes);

            $this->database->create(
                OrmModelMapper::UserServiceMappingsTable,
                [
                    "user_id" => $user->id,
                    "service_id" => $serviceId
                ]
            );

            $this->projectUploadManager->handleServiceUpload(
                $user,
                $this->database,
                $addServiceRequest->serviceName,
                $addServiceRequest->projectFiles,
                $serviceTypes,
                $isGitProject
            );

            $this->handleSuccess();
        } catch (ControllerException $e) {
            $this->handleError($e, $e->getMessage(), $e->getHttpErrorCode());
        }
    }

    public function deleteService($request)
    {
        try {
            $deleteServiceRequest = new DeleteServiceRequest($request);

            $this->database->delete(
                OrmModelMapper::ServicesTable->getModel(),
                ["service_id" => $deleteServiceRequest->serviceId]
            );

            $this->handleSuccess();
        } catch (ControllerException $e) {
            $this->handleError($e, $e->getMessage(), $e->getHttpErrorCode());
        }
    }

    public function getServiceDetails($request)
    {
        try {
            $getServiceDetailsRequest = new GetServiceDetailsRequest($request);

            $usersWithAccessToService = $this->database->read(
                OrmModelMapper::UserServiceMappingsTable,
                ["service_id" => $getServiceDetailsRequest->serviceId],
                ["user_id"]
            );

            $userDoingRequest = User::getUserFromJwt($this->cookieService, $this->securityManager);

            if (!in_array($userDoingRequest->id, $usersWithAccessToService)) {
                throw new ControllerException("Insufficient permissions to get service details", 403);
            }

            $serviceData = $this->database->read(
                OrmModelMapper::ServicesTable,
                ["serviceId" => $getServiceDetailsRequest->serviceId],
                ["service_owner_user_id", "service_name", "git_clone_url", "is_active"]
            );

            $serviceTypeData = $this->database->read(
                OrmModelMapper::ServiceTypesTable,
                ["service_id" => $getServiceDetailsRequest->serviceId],
                ["service_type_id", "type", "startup_location", "env_location", "port"]
            );

            $service = new Service($getServiceDetailsRequest->serviceId, $serviceData, $serviceTypeData, $usersWithAccessToService); // TODO
        } catch (ControllerException $e) {
            $this->handleError($e, $e->getMessage(), $e->getHttpErrorCode());
        }
    }

    public function getServices()
    {
        try {
            $userDoingRequest = User::getUserFromJwt($this->cookieService, $this->securityManager);

            $conditions = [];

            if (!$userDoingRequest->getIsAdmin($this->database)) {
                $conditions = ["user_id" => $userDoingRequest->id];
            }

            $serviceIds = $this->database->read(
                OrmModelMapper::UserServiceMappingsTable,
                $conditions,
                ["service_id"]
            );

            $services = []; // TODO: database magic that takes multiple data as conditions for the same row, to avoid spamming database->read over and over in a loop

            // TODO

        } catch (ControllerException $e) {
            $this->handleError($e, $e->getMessage(), $e->getHttpErrorCode());
        }
    }

    public function updateService($request)
    {
        try {
            $updateServiceRequest = new UpdateServiceRequest($request);

            $this->database->update(OrmModelMapper::ServicesTable, [], []);
        } catch (ControllerException $e) {
            $this->handleError($e, $e->getMessage(), $e->getHttpErrorCode());
        }
    }

    public function updateServiceType($request)
    {
        $updateServiceType = new updateServiceType($request);
    }

    public function updateServiceSource($request)
    {
        try {
        } catch (ControllerException $e) {
            $this->handleError($e, $e->getMessage(), $e->getHttpErrorCode());
        }
    }
}
