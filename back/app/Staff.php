<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    /**
     * Fillable fields for a staff.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'post'
    ];

    /**
     * Get the articles associated with the given person
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function articles()
    {
        return $this->belongsToMany('App\Article');
    }
}
