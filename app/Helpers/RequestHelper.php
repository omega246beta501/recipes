<?php
namespace App\Helpers;

use Illuminate\Http\Request;

class RequestHelper {
    public static function requestToArray(Request $request) : array {
        $data = $request->json()->all();
        if(empty($data)) {
            $data = $request->all();
        }

        return $data;
    }
}