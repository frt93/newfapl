<?php

namespace App\Http\Controllers\Models;

use App\Tag;
use App\Article;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;
use Illuminate\Support\Facades\Auth;
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
        return Article::where('id', '=', $id)
                        ->orderBy('id','asc')
                        ->first()
                        ->getSingleArticleData();
    }

    public function getArticlesRelationsData()
    {
        return Article::getRelationsData();
    }

    /**
     * Save a new Article.
     *
     * @param Article $article
     * @param ArticleRequest $request
     */
    public function storeArticle(Article $article, ArticleRequest $request)
    {
        return $article->store($request);
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
        $article->syncArticleData($article, $request);
        $article->checkPinnedStatusOnUpdate();
    }

    /**
     * Deactivate an article.
     *
     * @param Article $id
     * @return Response
     */

    public function deactivateArticle(Article $article, $id)
    {
        return $article->deactivate($id);
    }

    /**
     * Activate an article.
     *
     * @param Article $id
     * @return response
     */

    public function activateArticle(Article $article, $id)
    {
        return $article->activate($id);
    }

}
