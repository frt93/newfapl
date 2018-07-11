<?php

namespace App\Traits\Article;



use Carbon\Carbon;

trait Scopes {
    /**
     * Get all published articles matching the query.
     *
     * @param $query $request
     * @param $request
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
}