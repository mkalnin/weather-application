<?php

namespace App\Services\Weather\DataParsers;

use App\Models\WeatherApiSource;
use Illuminate\Support\Arr;

/**
 * Class WeatherApiSourceDataParser
 * Parses data received via api sources stored in
 * App\Model\WeatherApiSource
 *
 * @package App\Services\Weather\DataParsers
 */
class WeatherApiSourceDataParser
{
    /**
     * Get current temperature having path for json weather data object
     * @param string           $apiResponse
     * @param WeatherApiSource $weatherApiSource
     *
     * @return int
     */
    public function celsiusTemperature(string $apiResponse, WeatherApiSource $weatherApiSource): int
    {
        $temperatureData = json_decode($apiResponse, true);
        $temperature = Arr::get($temperatureData, $weatherApiSource->temperature_path);
        if ($weatherApiSource->is_celsius != true) {
            $temperature = $this->kelvinToCelsius($temperature);
        }

        return (int) $temperature;
    }

    /**
     * @param float $temperature
     *
     * @return int
     */
    protected function kelvinToCelsius(float $temperature): int
    {
        return (int) $temperature - 273.15;
    }
}
