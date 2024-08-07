<?php

namespace App\Helpers;

class GenerateCodeHelper
{
    public static function handleGenerateCode($aliases, $id)
    {
        return substr(hash('sha256', $aliases . time()), 0, $id);
    }
}
