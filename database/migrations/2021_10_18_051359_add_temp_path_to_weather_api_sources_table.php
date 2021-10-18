<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTempPathToWeatherApiSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('weather_api_sources', function (Blueprint $table) {
            $table->string('temperature_path')->after('city_query_param_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('weather_api_sources', function (Blueprint $table) {
            $table->dropColumn('temperature_path');
        });
    }
}
