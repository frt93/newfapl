<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

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

    /**
     * Get from the cache a list of all existing categories.
     *
     * @return Cache
     */
    public static function getCategoriesListFromCache()
    {
        if( !Cache::has('categoriesList') ) {
            (new static)->storeCategoriesListInCache();
        }
        return Cache::get('categoriesList');
    }

    /**
     * Grab list of all existing categories from the database and store them in cache
     *
     */
    public function storeCategoriesListInCache()
    {
        $categories = Category::all('id', 'name');
        Cache::put('categoriesList', $categories, Carbon::now()->addMinutes(10000));
    }

}
