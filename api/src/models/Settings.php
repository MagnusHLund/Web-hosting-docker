<?php

namespace MagZilla\Api\Models;

class Settings
{
    public readonly bool $darkMode;
    public readonly string $language;

    public function __construct($darkMode, $language)
    {
        $this->darkMode = $darkMode;
        $this->language = $language;
    }
}
