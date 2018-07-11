<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

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

    /**
     * Get from the cache a list of all existing staff.
     *
     * @return Cache
     */
    public static function getStaffListFromCache()
    {
        if( !Cache::has('staffList') ) {
            (new static)->storeStaffListInCache();
        }
        return Cache::get('staffList');
    }

    /**
     * Grab list of all existing staff from the database and store them in cache
     *
     */
    public function storeStaffListInCache()
    {
        $staff = Staff::all('id', 'name');
        Cache::put('staffList', $staff, Carbon::now()->addMinutes(60));
    }
}
