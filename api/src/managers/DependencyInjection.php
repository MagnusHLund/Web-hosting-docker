<?php

namespace MagZilla\Api\Managers;

use DI\ContainerBuilder;
use MagZilla\Api\Controllers\AuthenticationController;
use MagZilla\Api\Controllers\ServiceController;
use MagZilla\Api\Controllers\UserController;
use MagZilla\Api\Managers\DatabaseManager;

class DependencyInjection
{
    private $container;

    public function __construct()
    {
        $containerBuilder = new ContainerBuilder();
        $this->container = $containerBuilder->build();
    }

    public function registerDependencies()
    {
        $this->container->set(DatabaseManager::class, \DI\factory([DatabaseManager::class, 'getInstance']));
        $this->container->set(AuthenticationController::class, \DI\create(AuthenticationController::class)->constructor($this->container->get(DatabaseManager::class)));
        $this->container->set(ServiceController::class, \DI\create(ServiceController::class)->constructor($this->container->get(DatabaseManager::class)));
        $this->container->set(UserController::class, \DI\create(UserController::class)->constructor($this->container->get(DatabaseManager::class)));

        return $this->container;
    }
}
