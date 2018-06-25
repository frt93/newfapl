<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Fillable fields for a category.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'parent_id',
        'slug'
    ];

    /**
     * Get the articles associated with the given category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function articles()
    {
        return $this->belongsToMany('App\Article');
    }

}
