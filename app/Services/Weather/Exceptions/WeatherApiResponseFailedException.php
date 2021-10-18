<?php

namespace App\Services\Weather\Exceptions;

use Exception;

/**
 * Class WeatherApiResponseFailedException
 *
 * @package App\Services\Weather\Exceptions
 */
class WeatherApiResponseFailedException extends Exception
{
    protected $message = 'Api call failed.';
}
