<?php
namespace App\Helpers;

use Illuminate\Support\Pluralizer;
use Illuminate\Support\Str;

class FormatHelper {
    public static function ingredientNameFormat($name) {
        $name = Str::title(Str::squish($name));
        
        return $name;
    }

    // set to null if empty
    public static function nullIfEmpty($value) {
        if(empty($value)) {
            return null;
        }
        else {
            return $value;
        }
    }
}