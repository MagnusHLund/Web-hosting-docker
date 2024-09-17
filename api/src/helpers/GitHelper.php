<?php

namespace MagZilla\Helpers;

class GitHelper
{
    private static $instance = null;

    private function __construct() {}

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new GitHelper();
        }
        return self::$instance;
    }

    public function GitClone($url, $repoLocation) {}

    public function GitPull($url, $repoLocation) {}
}
