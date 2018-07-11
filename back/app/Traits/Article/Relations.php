<?php

namespace App\Traits\Article;

use App\Article;
use App\Http\Requests\ArticleRequest;
use App\Tag;

trait Relations {

    /**
     * Sync up all of article relations data in the database.
     *
     * @param Article $article
     * @param  ArticleRequest $request
     */
    public function syncArticleData(Article $article, ArticleRequest $request)
    {
        $article->syncTags($request->input('tag_list'));
        $article->syncClubs($request->input('club_list'));
        $article->syncStaff($request->input('staff_list'));
        $article->syncPlayers($request->input('player_list'));
        $article->syncCategories($request->input('category_list'));
        $article->syncCompetitions($request->input('competition_list'));
        $article->checkPinnedStatusOnUpdate();
    }

    /**
     * Sync up the list of tags in the database.
     *
     * @param array $tags
     */
    public function syncTags($tags)
    {
        $tagsList = [];
        foreach ($tags as $tag) {
            $tag = Tag::firstOrCreate(['name' => $tag]);
            array_push($tagsList, $tag['id']);
        }
        $this->tags()->sync($tagsList);
    }

    /**
     * Sync up the list of clubs in the database.
     *
     * @param array $clubs
     */
    public function syncClubs($clubs)
    {
        $this->clubs()->sync($clubs);
    }

    /**
     * Sync up the list of categories in the database.
     *
     * @param array $categories
     */
    public function syncCategories($categories)
    {
        $this->categories()->sync($categories);
    }

    /**
     * Sync up the list of competitions in the database.
     *
     * @param array $competitions
     */
    public function syncCompetitions($competitions)
    {
        $this->competitions()->sync($competitions);
    }

    /**
     * Sync up the list of players in the database.
     *
     * @param array $players
     */
    public function syncPlayers($players)
    {
        $this->players()->sync($players);
    }

    /**
     * Sync up the list of staff in the database.
     *
     * @param array $staff
     */
    public function syncStaff($staff)
    {
        $this->staff()->sync($staff);
    }




    /**
     * An article can belong to only one user(author).
     * We can obtain this user by calling $article->user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * An article can be associated with many tags.
     * We can obtain this tags by calling $article->tags
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function tags()
    {
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }

    /**
     * An article can belong to many categories.
     * We can obtain this categories by calling $article->categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function categories()
    {
        return $this->belongsToMany('App\Category')->withTimestamps();
    }

    /**
     * An article can be associated with many competitions.
     * We can obtain this competitions by calling $article->competitions
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function competitions()
    {
        return $this->belongsToMany('App\Competition')->withTimestamps();
    }

    /**
     * An article can be associated with many players.
     * We can obtain this players by calling $article->players
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function players()
    {
        return $this->belongsToMany('App\Player')->withTimestamps();
    }

    /**
     * An article can be associated with many clubs.
     * We can obtain this clubs by calling $article->clubs
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function clubs()
    {
        return $this->belongsToMany('App\Club')->withTimestamps();
    }
    /**
     * An article can be associated with many staff ( club personal ).
     * We can obtain this staff by calling $article->staff
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function staff()
    {
        return $this->belongsToMany('App\Staff')->withTimestamps();
    }







//
//    /**
//     * Get a list of tag ids associated with current article
//     *
//     *
//     */
//    public function getTagListAttribute()
//    {
//        return $this->tags->pluck('name');
//    }
//
//    /**
//     * Get a list of categories ids associated with current article
//     *
//     * @return array
//     */
//    public function getCategoryListAttribute()
//    {
//        return $this->categories->pluck('id');
//    }
//
//
//
//    /**
//     * Get a list of competitions ids associated with current article
//     *
//     * @return array
//     */
//    public function getCompetitionListAttribute()
//    {
//        return $this->competitions->pluck('id');
//    }
//
//
//
//    /**
//     * Get a list of players ids associated with current article
//     *
//     * @return array
//     */
//    public function getPlayerListAttribute()
//    {
//        return $this->players->pluck('id');
//    }
//
//
//    /**
//     * Get a list of clubs ids associated with current article
//     *
//     * @return array
//     */
//    public function getClubListAttribute()
//    {
//        return $this->clubs->pluck('id');
//    }
//
//
//
//    /**
//     * Get a list of staff ids associated with current article
//     *
//     * @return array
//     */
//    public function getStaffListAttribute()
//    {
//        return $this->staff->pluck('id');
//    }
}
