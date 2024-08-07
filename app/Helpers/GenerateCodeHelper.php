<?php

namespace App\Helpers;

use App\Models\Category;

class GenerateCodeHelper
{
    public static function handleGenerateCode($categoryID)
    {
        $category =  Category::find($categoryID);
        $aliases = $category->aliases;

        return $aliases . time();
    }
}