<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WeatherApiSource
 *
 * @property int $id
 * @property string $name
 * @property string $api_host
 * @property string|null $api_key
 * @property string|null $api_key_query_param_name
 * @property string|null $city_query_param_name
 * @property bool $is_celsius
 *
 * @package App\Models
 */
class WeatherApiSource extends Model
{

}
