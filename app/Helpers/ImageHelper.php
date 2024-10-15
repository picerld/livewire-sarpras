<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;

class ImageHelper
{
    public static function handleImage(UploadedFile|String $image)
    {
        if ($image instanceof UploadedFile) {
            $imageName = time() . '.' . $image->extension();
            $imagePath = $image->storeAs('public', $imageName);
            return basename($imagePath);
        } elseif (is_string($image)) {
            return $image;
        }

        return null;
    }
}
