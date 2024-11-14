<?php

namespace MagZilla\Api\Models;

class Settings
{
    public readonly bool $darkMode;
    public readonly string $language;

    public function __construct(bool $darkMode, string $language)
    {
        $this->darkMode = $darkMode;
        $this->language = $language;
    }
}
