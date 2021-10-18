<?php

namespace App\Services\Weather;

use App\Models\WeatherHistoryRequest;

class WeatherHistoryRequestService
{
    /**
     * @param string $query
     *
     * @return void
     */
    public function create(string $query): void
    {
        $request = new WeatherHistoryRequest();
        $request->query = $query;
        $request->save();
    }
}
