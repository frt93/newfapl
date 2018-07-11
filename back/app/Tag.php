<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Tag extends Model
{
    /**
     * Fillable fields for a tag.
     *
     * @var array
     */
    protected $fillable = [
        'name'
        ];

    /**
     * Get the articles associated with the given tag
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function articles()
    {
        return $this->belongsToMany('App\Article');
    }

    /**
     * Get from the cache a list of all existing tags.
     *
     * @return Cache
     */
    public static function getTagsListFromCache()
    {
        if( !Cache::has('tagsList') ) {
            (new static)->storeTagsListInCache();
        }
        return Cache::get('tagsList');
    }

    /**
     * Grab list of all existing tags from the database and store them in cache
     *
     */
    public function storeTagsListInCache()
    {
        $tags = Tag::all('id', 'name');
        Cache::put('tagsList', $tags, Carbon::now()->addMinutes(60));
    }
}
