<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalSetting extends Model
{
    use HasFactory;

    public static $IS_BRING_ACTIVE = 'is_bring_active';

    static function findBykey($key){
        return InternalSetting::where('key', $key)->first();
    }

    static function getValue($key) {
        return InternalSetting::where('key', $key)->first()->value;
    }

    static function setValue($key, $value) {
        $setting = InternalSetting::where('key', $key)->first();
        if($setting) {
            $setting->value = $value;
            $setting->save();
        }
    }
}
