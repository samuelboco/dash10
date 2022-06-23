<?php

namespace App\Api;

use Illuminate\Support\Facades\Http;

class Service
{
    public static function get($sBaseEndpoint, $sEndpointTail = '', $aQueryString = [])
    {
        $aQueryString = array_merge(['API_KEY' => config('api.key')], $aQueryString);
        $aApiResponse = Http::get("$sBaseEndpoint/$sEndpointTail", $aQueryString)->json();

        return $aApiResponse;
    }
}