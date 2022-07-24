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

    private static function decimalPart($float) {
        return sscanf($float, '%d.%d')[1];
    }

    public static function floatToIntQty($value) {
        if($value != null) {
            if(self::decimalPart($value) == null) {
                $value = (int) $value;
            }
        }
        return $value;
    }
}