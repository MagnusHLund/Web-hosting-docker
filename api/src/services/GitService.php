<?php

namespace MagZilla\Api\Services;

use MagZilla\Api\Models\Exceptions\ControllerException;

class GitService
{
    public function cloneGitRepository(string $cloneUrl, string $targetDirectory)
    {
        try {
            if (!is_dir($targetDirectory)) {
                mkdir($targetDirectory, 0777, true);
            }

            $command = sprintf('git clone %s %s', escapeshellarg($cloneUrl), escapeshellarg($targetDirectory));
            exec($command, $output, $returnVar);

            if (!empty($returnVar)) {
                throw new \Exception("Failed to git clone. Url: $cloneUrl, Directory: $targetDirectory");
            }
        } catch (\Exception $e) {
            throw new ControllerException("Unable to clone Github project", 500, $e);
        }
    }

    public function pullGitRepository($url, $repoLocation) {}
}
