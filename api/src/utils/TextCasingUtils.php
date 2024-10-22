<?php

namespace MagZilla\Api\Utils;

class TextUtils
{
    public static function camelToSnake($camelCaseText)
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $camelCaseText));
    }

    public static function isUrl($text)
    {
        $regexPattern = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        return (bool) preg_match($regexPattern, $text);
    }
}
