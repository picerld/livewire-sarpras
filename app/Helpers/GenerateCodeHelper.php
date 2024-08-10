<?php

namespace App\Helpers;

use App\Models\Category;
use Illuminate\Support\Str;

class GenerateCodeHelper
{
    public static function handleGenerateCode()
    {
        // param: category_id
        
        // PRODUCTION
        // $category =  Category::find($categoryID);
        // $aliases = $category->aliases;

        // DEVELOPMENT
        $code = random_int(100000, 999999);

        return $code;
    }
}