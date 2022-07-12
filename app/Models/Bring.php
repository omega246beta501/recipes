<?php

namespace App\Models;

use App\Data\Routes\BringRoutes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bring extends Model
{
    use HasFactory;
    protected $table = 'bring';

    public static function getToken()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => BringRoutes::GET_TOKEN,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "email=ruben_ayg@hotmail.com&password=M3cag03ndi0s!!1",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        //throw exception if err
        if ($err) {
            return null;
        }
        else {
            $response = json_decode($response);
            $bring = Bring::findOrFail(1);
            $bring->uuid = $response->uuid;
            $bring->public_uuid = $response->publicUuid;
            $bring->token = $response->access_token;
            $bring->save();

            return $bring;
        }
    }

    public function addIngredient($ingredient) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => BringRoutes::BRING_LISTS . '3dcdcff8-e12e-413c-a40f-f6c03afe507d',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => "uuid=3dcdcff8-e12e-413c-a40f-f6c03afe507d&purchase=" . $ingredient->name . "&specification=" . $ingredient->pivot->description,
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "authorization: Bearer " . $this->token,
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        //throw exception if err
        if ($err) {
            return null;
        }
        else {
            $response = json_decode($response);
            return $response;
        }
    }
}
