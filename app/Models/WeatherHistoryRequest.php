<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class WeatherHistoryRequest
 *
 * @property string $query
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class WeatherHistoryRequest extends Model
{
    /**
     * Get records created max $days ago
     * @param Builder $query
     * @param int     $days
     *
     * @return Builder
     */
    public function scopeNotOlderThan(Builder $query, int $days): Builder
    {
        $date = Carbon::today()->subDays($days);

        return $query->where('created_at', '>=', $date);
    }
}
