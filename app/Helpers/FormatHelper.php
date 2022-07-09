<?php
namespace App\Helpers;

use Illuminate\Support\Pluralizer;
use Illuminate\Support\Str;

class FormatHelper {
    public static function ingredientNameFormat($name) {
        $name = Str::title(Str::squish($name));
        
        return $name;
    }
}