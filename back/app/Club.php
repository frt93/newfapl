<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Club extends Model
{
    /**
     * Fillable fields for a Club.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug'
    ];

    /**
     * Get the articles associated with the given club
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function articles()
    {
        return $this->belongsToMany('App\Article');
    }

    /**
     * Get from the cache a list of all existing clubs.
     *
     * @return Cache
     */
    public static function getClubsListFromCache()
    {
        if( !Cache::has('clubsList') ) {
            (new static)->storeClubsListInCache();
        }
        return Cache::get('clubsList');
    }

    /**
     * Grab list of all existing clubs from the database and store them in cache
     *
     */
    public function storeClubsListInCache()
    {
        $clubs = Club::all('id', 'name');
        Cache::put('clubsList', $clubs, Carbon::now()->addMinutes(60));
    }
}
