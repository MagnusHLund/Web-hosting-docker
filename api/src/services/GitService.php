<?php

namespace MagZilla\Api\Helpers;

use MagZilla\Api\Services\NetworkRequestService;

// TODO?: Remove this class?
class GitService
{
    private readonly NetworkRequestService $networkRequestService;

    public function __construct()
    {
        $this->networkRequestService = NetworkRequestService::getInstance();
    }

    public function gitClone($url)
    {
        $this->networkRequestService->sendGetRequest($url);
    }

    public function gitPull($url, $repoLocation) {}
}
