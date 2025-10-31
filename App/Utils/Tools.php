<?php

namespace App\Utils;

class Tools
{
    public static function sanitize(string $value):string
    {

        return htmlspecialchars(strip_tags(trim($value)), ENT_NOQUOTES);
    }

}