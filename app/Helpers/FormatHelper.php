<?php
namespace App\Helpers;

use Illuminate\Support\Pluralizer;
use Illuminate\Support\Str;

class FormatHelper {
    public static function ingredientNameFormat($name) {
        Pluralizer::uselanguage('spanish');
        $name = Str::singular(Str::title(Str::squish($name)));
        Pluralizer::uselanguage('english');
        
        return $name;
    }
}