<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Player extends Model
{
    /**
     * Fillable fields for a player.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'club'
    ];

    /**
     * Get the articles associated with the given player
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function articles()
    {
        return $this->belongsToMany('App\Article');
    }

    /**
     * Get from the cache a list of all existing players.
     *
     * @return Cache
     */
    public static function getPlayersListFromCache()
    {
        if( !Cache::has('playersList') ) {
            (new static)->storePlayersListInCache();
        }
        return Cache::get('playersList');
    }

    /**
     * Grab list of all existing players from the database and store them in cache
     *
     */
    public function storePlayersListInCache()
    {
        $players = Player::all('id', 'name');
        Cache::put('playersList', $players, Carbon::now()->addMinutes(60));
    }
}
