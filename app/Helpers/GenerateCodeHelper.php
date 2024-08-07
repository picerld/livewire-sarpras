<?php

namespace App\Helpers;

<<<<<<< HEAD
use App\Models\Category;

class GenerateCodeHelper
{
    public static function handleGenerateCode($categoryID)
    {
        $category =  Category::find($categoryID);
        $aliases = $category->aliases;

        return $aliases . time();
=======
class GenerateCodeHelper
{
    public static function handleGenerateCode($aliases, $id)
    {
        return substr(hash('sha256', $aliases . time()), 0, $id);
>>>>>>> faa95b83bec67b4ce7b381a422654c3e64f2496c
    }
}
