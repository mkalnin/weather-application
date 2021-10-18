<?php

namespace App\Http\Api\V1\Controllers;

use App\Models\WeatherApiSource;
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
        $weatherApiSources = $this->allWeatherApiSources();
        foreach ($weatherApiSources as $weatherApiSource) {
            $weather = $weatherService->getWeatherByLocationName('New York', $weatherApiSource);
        }
        die();
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
