<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Competition extends Model
{
    /**
     * Fillable fields for a Competition.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug'
    ];

    /**
     * Get the articles associated with the given competition
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function articles()
    {
        return $this->belongsToMany('App\Article');
    }

    /**
     * Get from the cache a list of all existing competitions.
     *
     * @return Cache
     */
    public static function getCompetitionsListFromCache()
    {
        if( !Cache::has('competitionsList') ) {
            (new static)->storeCompetitionsListInCache();
        }
        return Cache::get('competitionsList');
    }

    /**
     * Grab list of all existing competitions from the database and store them in cache
     *
     */
    public function storeCompetitionsListInCache()
    {
        $competitions = Competition::all('id', 'name');
        Cache::put('competitionsList', $competitions, Carbon::now()->addMinutes(60));
    }
}
