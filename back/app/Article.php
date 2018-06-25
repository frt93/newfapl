<?php namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;


class Article extends Model
{
    protected $fillable = [
        'title',
        'excerpt',
        'body',
        'published_at',
        'author'
    ];

    protected $dates = ['published_at'];


    /**
     * Get all published articles matching the query.
     *
     * @param $query $request
     */
    public function scopePublished($query, $request)
    {
        if (($request->co) || ($request->pl) || ($request->club)) {
            $playerName = $request->pl;
            $clubName = $request->club;
            $competitionName = $request->co;

            $query->where('published_at', '<=', Carbon::now())
                ->when($playerName, function ($query) use ($playerName) {
                    return $query->join('article_player', 'articles.id', '=', 'article_player.article_id')
                        ->join('players', 'players.id', '=', 'article_player.player_id')
                        ->select('articles.*', 'article_player.article_id')
                        ->where('players.slug', $playerName)->distinct();
                })
                ->when($clubName, function ($query) use ($clubName) {
                    return $query->join('article_club', 'articles.id', '=', 'article_club.article_id')
                        ->join('clubs', 'clubs.id', '=', 'article_club.club_id')
                        ->select('articles.*', 'article_club.article_id')
                        ->where('clubs.slug', $clubName)->distinct();
                })
                ->when($competitionName, function ($query) use ($competitionName) {
                    return $query->join('article_competition', 'articles.id', '=', 'article_competition.article_id')
                        ->join('competitions', 'competitions.id', '=', 'article_competition.competition_id')
                        ->select('articles.*', 'article_competition.article_id')
                        ->where('competitions.slug', $competitionName)->distinct();
                })
                ->get();
        }
    }

    /**
     * Get all unpublished articles matching the query.
     *
     * @param $query
     */
    public function scopeUnPublished($query)
    {
        $query->where('published_at', '>', Carbon::now());
    }


    /**
     * Set the date format for  'published_at' attribute of article.
     *
     * @param $date
     */
    public function setPublishedAtAttribute($date) 
    {
        $this->attributes['published_at'] = Carbon::createFromFormat('Y-m-d H:i:s', $date);
    }

    public function getPublishedAtAttribute($date)
    {
        return Carbon::parse($date)->toDateTimeString();
    }


    /**
     * An article is owned by user(author).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the tags, associated with the given article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function tags()
    {
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }

    /**
     * Get a list of tag ids associated with current article
     *
     * @return array
     */
    public function getTagListAttribute()
    {
        return $this->tags->pluck('name');
    }

    /**
     * Get the tags, associated with the given article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function categories()
    {
        return $this->belongsToMany('App\Category')->withTimestamps();
    }

    /**
     * Get a list of categories ids associated with current article
     *
     * @return array
     */
    public function getCategoryListAttribute()
    {
        return $this->categories->pluck('id');
    }

    /**
     * Get the competitions, associated with the given article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function competitions()
    {
        return $this->belongsToMany('App\Competition')->withTimestamps();
    }

    /**
     * Get a list of competitions ids associated with current article
     *
     * @return array
     */
    public function getCompetitionListAttribute()
    {
        return $this->competitions->pluck('id');
    }

    /**
     * Get the players, associated with the given article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function players()
    {
        return $this->belongsToMany('App\Player')->withTimestamps();
    }

    /**
     * Get a list of players ids associated with current article
     *
     * @return array
     */
    public function getPlayerListAttribute()
    {
        return $this->players->pluck('id');
    }

    /**
     * Get the clubs, associated with the given article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function clubs()
    {
        return $this->belongsToMany('App\Club')->withTimestamps();
    }

    /**
     * Get a list of clubs ids associated with current article
     *
     * @return array
     */
    public function getClubListAttribute()
    {
        return $this->clubs->pluck('id');
    }

    /**
     * Get the staff, associated with the given article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function staff()
    {
        return $this->belongsToMany('App\Staff')->withTimestamps();
    }

    /**
     * Get a list of staff ids associated with current article
     *
     * @return array
     */
    public function getStaffListAttribute()
    {
        return $this->staff->pluck('id');
    }
}
