<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWeatherApiSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weather_api_sources', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->index();
            $table->string('api_host');
            $table->string('api_key')->nullable();
            $table->string('api_key_query_param_name')->nullable();
            $table->string('city_query_param_name')->nullable();
            $table->boolean('is_celsius');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weather_api_sources');
    }
}
