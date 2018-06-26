<?php

namespace App\Http\Controllers\Models;

use App\Tag;
use App\Article;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;


trait Articles {
    /**
     * Get all published articles matching the query.
     *
     * @param Request $request
     * @return array
     */
    public function getLastArticles(Request $request)
    {
        $articles = Article::latest('published_at')->published($request)->paginate(10);
        return $articles;
    }

    /**
     * Get pinned article
     *
     * @return array
     */
    public function getPinnedArticle()
    {
        if( !Redis::exists('pinnedArticle') ) {
            Redis::set('pinnedArticle', Article::where('pinned', '=', 1)->orderBy('id','asc')->first());
        }
        return Redis::get('pinnedArticle');
    }

    /**
     * Get an article
     *
     * @param $id
     * @return array
     */
    public function getArticle($id)
    {
        $article = Article::where('id', '=', $id)->orderBy('id','asc')->first();
        return collect([
            'title' => $article->title,
            'excerpt' => $article->excerpt,
            'body' => $article->body,
            'id' => $article->id,
            'published' => $article->published,
            'pinned' => $article->pinned,
            'date' => $article->published_at,
            'author' => $article->author,
            'categories' => $article->categories,

            'allTags' => Tag::all('id', 'name'),
            'pickedTags' => $article->tags->pluck('name'),

            'competitions' => $article->competitions,
            'players' => $article->players,
            'clubs' => $article->clubs,
            'staff' => $article->staff,
            'previous' => Article::where('id', '<', $id)->orderBy('id','desc')->first(),
            'next' => Article::where('id', '>', $id)->orderBy('id','asc')->first(),

        ]);
    }

    /**
     * Save a new article.
     *
     * @param ArticleRequest $request
     * @return mixed
     */
    private function createArticle(ArticleRequest $request)
    {
        $article = \Auth::user()->articles()->create($request->all());
        $this->syncArticleData($article, $request);

        return $article;
    }

    /**
     * Update an article.
     *
     * @param Article $article
     * @param ArticleRequest $request
     */

    public function updateArticle(Article $article, ArticleRequest $request)
    {
        $article->update($request->all());
        $this->syncArticleData($article, $request);

        $article->checkPinnedStatusOnUpdate();
    }

    /**
     * Sync up all of article metadata in the database.
     * @param Article $article
     * @param  ArticleRequest $request
     */
    private function syncArticleData(Article $article, ArticleRequest $request)
    {
        $this->syncTags($article, $request->input('tag_list'));
        $this->syncClubs($article, $request->input('club_list'));
        $this->syncStaff($article, $request->input('staff_list'));
        $this->syncPlayers($article, $request->input('player_list'));
        $this->syncCategories($article, $request->input('category_list'));
        $this->syncCompetitions($article, $request->input('competition_list'));
    }

    /**
     * Sync up the list of tags in the database.
     * @param Article $article
     * @param array $tags
     */
    public function syncTags(Article $article, $tags)
    {
        $tagsList = [];
        foreach ($tags as $tag) {
            $tag = Tag::firstOrCreate(['name' => $tag]);
            array_push($tagsList, $tag['id']);
        }
        $article->tags()->sync($tagsList);
    }

    /**
     * Sync up the list of categories in the database.
     * @param Article $article
     * @param array $categories
     */
    public function syncCategories(Article $article, $categories)
    {
        $article->categories()->sync($categories);
    }

    /**
     * Sync up the list of competitions in the database.
     * @param Article $article
     * @param array $competitions
     */
    public function syncCompetitions(Article $article, $competitions)
    {
        $article->competitions()->sync($competitions);
    }

    /**
     * Sync up the list of players in the database.
     * @param Article $article
     * @param array $players
     */
    public function syncPlayers(Article $article, $players)
    {
        $article->players()->sync($players);
    }

    /**
     * Sync up the list of clubs in the database.
     * @param Article $article
     * @param array $clubs
     */
    public function syncClubs(Article $article, $clubs)
    {
        $article->clubs()->sync($clubs);
    }

    /**
     * Sync up the list of staff in the database.
     * @param Article $article
     * @param array $staff
     */
    public function syncStaff(Article $article, $staff)
    {
        $article->staff()->sync($staff);
    }


    /**
     * Deactivate an article.
     *
     * @param Article $id
     * @return Response
     */

    public function deactivateArticle($id)
    {
        Article::where('id', $id)->update(['published' => false]);
        return response()->json([
            'value' => false
        ]);
    }

    /**
     * Activate an article.
     *
     * @param Article $id
     * @return response
     */

    public function activateArticle($id)
    {
        Article::where('id', $id)->update(['published' => true]);
        return response()->json([
            'value' => true
        ]);
    }

}
