<?php

namespace App\Http\Api\V1\Controllers;

use App\Models\WeatherApiSource;
use App\Models\WeatherHistoryRequest;
use App\Services\Weather\Exceptions\WeatherApiResponseFailedException;
use App\Services\Weather\WeatherHistoryRequestService;
use App\Services\Weather\WeatherService;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\DB;

/**
 * Class WeatherController
 *
 * @package App\Http\Api\V1\Controllers
 */
class WeatherController extends Controller
{
    /**
     * Get weather data by city name via Api
     * @param string                       $name
     * @param WeatherService               $weatherService
     * @param WeatherHistoryRequestService $historyRequestService
     *
     * @return Response
     */
    public function byCityName(
        string $name,
        WeatherService $weatherService,
        WeatherHistoryRequestService $historyRequestService
    ): Response {
        $weather = [];
        $weatherApiSources = $this->allWeatherApiSources();
        $locationName = str_ireplace('_', ' ', $name);
        $historyRequestService->create($locationName);
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
     * Show history of weather requests
     * @param int $numberOfQueries  [limits number of unique queries returned]
     * @param int $maxDaysAgo       [limits maximal days ago for historical data]
     *
     * @return Response
     */
    public function getHistory(int $numberOfQueries, int $maxDaysAgo): Response
    {
        $history = WeatherHistoryRequest::notOlderThan($maxDaysAgo)
            ->select('query', DB::raw('count(*) as count'))
            ->groupBy('query')
            ->orderBy('count', 'DESC')
            ->limit($numberOfQueries)
            ->get();

        return \response($history);
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
