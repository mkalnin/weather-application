<?php

namespace App\Http\Api\V1\Controllers;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class WeatherController
 *
 * @package App\Http\Api\V1\Controllers
 */
class WeatherController extends Controller
{
    /**
     * @param string $name
     *
     * @return Response
     */
    public function byCityName(string $name): Response
    {
        return \response($name);
    }
}
