<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
