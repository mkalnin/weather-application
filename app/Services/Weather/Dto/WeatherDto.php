<?php

namespace App\Services\Weather\Dto;

/**
 * Class WeatherDto
 *
 * @package App\Services\Weather\Dto
 */
class WeatherDto
{
    public function __construct(
        public string $sourceName,
        public int $celsiusTemperature
    ) {
    }
}
