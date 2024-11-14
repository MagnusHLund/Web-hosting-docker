<?php

namespace MagZilla\Api\Models;

class FileUpload
{
    public readonly mixed $file; // Idk the type
    public readonly string $uploadDirectory;

    public function __construct($file, $uploadDirectory)
    {
        $this->file = $file;
        $this->uploadDirectory = $uploadDirectory;
    }
}
