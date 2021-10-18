<?php

namespace App\Services\Weather;

use App\Models\WeatherApiSource;
use Illuminate\Support\Facades\Http;

/**
 * Class WeatherService
 *
 * @package App\Services\Weather
 */
class WeatherService
{
    public function getWeatherByLocationName(
        string $locationName,
        WeatherApiSource $weatherApiSource
    ) {
        var_dump(Http::get($weatherApiSource->api_host, [
            $weatherApiSource->api_key_query_param_name => $weatherApiSource->api_key,
            $weatherApiSource->city_query_param_name => $locationName
        ])->body());
    }
}
