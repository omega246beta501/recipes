<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Setting extends Model
{
    use HasFactory;
    public static $IS_BRING_ACTIVE = 'is_bring_active';

    protected $fillable = ['key'];

    static function findBykey($key){
        $user = Auth::user();
        $setting = $user->settings()->where('key', $key)->first();
        return $setting->pivot->value;
    }

    static function getValue($key) {
        $user = Auth::user();
        $setting = $user->settings()->where('key', $key)->first();
        return $setting->pivot->value;
    }

    static function setValue($key, $value) {
        $user = Auth::user();
        $setting = $user->settings()->where('key', $key)->first();
        if($setting) {
            $setting->pivot->value = $value;
            $setting->pivot->save();
        } 
    }
}
