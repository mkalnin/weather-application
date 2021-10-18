<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WeatherApiSourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('weather_api_sources')->insert([
            'name' => 'openweathermap',
            'api_host' => 'api.openweathermap.org/data/2.5/weather',
            'api_key' => '00418375acd88cc9a38419c141752895',
            'api_key_query_param_name' => 'appid',
            'city_query_param_name' => 'q',
            'temperature_path' => 'main.temp',
            'is_celsius' => false,
        ]);

        DB::table('weather_api_sources')->insert([
            'name' => 'weatherstack',
            'api_host' => 'http://api.weatherstack.com/current',
            'api_key' => '2e16899f6fd3feea0c542dc5d8329be0',
            'api_key_query_param_name' => 'access_key',
            'city_query_param_name' => 'query',
            'temperature_path' => 'current.temperature',
            'is_celsius' => true,
        ]);
    }
}
