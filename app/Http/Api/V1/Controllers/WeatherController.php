<?php

namespace App\Http\Api\V1\Controllers;

use App\Models\WeatherApiSource;
use App\Services\Weather\Exceptions\WeatherApiResponseFailedException;
use App\Services\Weather\WeatherService;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class WeatherController
 *
 * @package App\Http\Api\V1\Controllers
 */
class WeatherController extends Controller
{
    /**
     * @param string         $name
     * @param WeatherService $weatherService
     *
     * @return Response
     */
    public function byCityName(string $name, WeatherService $weatherService): Response
    {
        $weather = [];
        $weatherApiSources = $this->allWeatherApiSources();
        $locationName = str_ireplace('_', ' ', $name);
        foreach ($weatherApiSources as $weatherApiSource) {
            try {
                $weather['success'][] = $weatherService->getWeatherByLocationName($locationName, $weatherApiSource);
            } catch (WeatherApiResponseFailedException $exception) {
                $weather['error'][] = ['name' => $weatherApiSource->name, 'message' => $exception->getMessage()];
            }
        }
        if (isset($weather['success'])) {
            $weather['success'][] = $weatherService->getAverageWeather($weather['success']);
        }

        return \response($weather);
    }

    /**
     * Get all available weather api sources
     * @return Collection|array
     */
    private function allWeatherApiSources(): Collection|array
    {
        $weatherApiSources = WeatherApiSource::all();
        if ($weatherApiSources->count() == 0)
        {
            throw new NotFoundHttpException();
        }

        return $weatherApiSources;
    }
}
