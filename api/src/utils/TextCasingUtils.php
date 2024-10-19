<?php

namespace MagZilla\Api\Utils;

class TextCasingUtils
{
    public static function camelToSnake($camelCaseText)
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $camelCaseText));
    }
}
