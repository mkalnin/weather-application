<?php

namespace App\Services\Weather;

use App\Models\WeatherApiSource;
use App\Services\Weather\DataParsers\WeatherApiSourceDataParser;
use App\Services\Weather\Dto\WeatherDto;
use App\Services\Weather\Exceptions\WeatherApiResponseFailedException;
use Illuminate\Support\Facades\Http;

/**
 * Class WeatherService
 *
 * @package App\Services\Weather
 */
class WeatherService
{
    /**
     * @param WeatherApiSourceDataParser $apiSourceDataParser
     */
    public function __construct(
        private WeatherApiSourceDataParser $apiSourceDataParser
    ) {
    }

    /**
     * @param string           $locationName
     * @param WeatherApiSource $weatherApiSource
     *
     * @return WeatherDto
     * @throws WeatherApiResponseFailedException
     */
    public function getWeatherByLocationName(
        string $locationName,
        WeatherApiSource $weatherApiSource
    ): WeatherDto {
        $response = Http::get($weatherApiSource->api_host, [
            $weatherApiSource->api_key_query_param_name => $weatherApiSource->api_key,
            $weatherApiSource->city_query_param_name => $locationName
        ]);
        /* TODO all apis return different errors (sadly) need to specify errors */
        if ($response->status() != 200) {
            throw new WeatherApiResponseFailedException();
        }
        $celsiusTemperature = $this->apiSourceDataParser->celsiusTemperature($response->body(), $weatherApiSource);

        return new WeatherDto(
            $weatherApiSource->name,
            $celsiusTemperature
        );
    }

    /**
     * @param array $weatherData
     *
     * @return WeatherDto|null
     */
    public function getAverageWeather(array $weatherData): ?WeatherDto
    {
        if (empty($weatherData)) return null;
        $temperature = 0;
        foreach ($weatherData as $weather)
        {
            /** @var WeatherDto $weather */
            $temperature += $weather->celsiusTemperature;
        }

        return new WeatherDto(
            'average',
            (int) $temperature / count($weatherData)
        );
    }
}
