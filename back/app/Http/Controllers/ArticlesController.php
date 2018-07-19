<?php namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;


class ArticlesController extends Controller
{
    /**
     * Get all published articles matching the query.
     *
     * @param Article $article
     * @param Request $request
     * @return mixed
     */
    public function index(Article $article, Request $request)
    {
        return $article->getArticles($request);
    }


    /**
     * Get pinned article
     *
     * @param Article $article
     * @return mixed
     */
    public function getPinnedArticle(Article $article)
    {
        return $article->pinned();
    }

    /**
     * Get an article
     *
     * @param Article $article
     * @param Article $id
     *
     * @return mixed
     */
    public function show(Article $article, $id)
    {
        return $article->articleData($id, 'show');
    }

    /**
     * Get an edited article
     *
     * @param Article $article
     * @param Article $id
     *
     * @return mixed
     */
    public function edit(Article $article, $id)
    {
        return $article->articleData($id, 'edit');
    }


    /**
     * Get required metadata for creating an article
     *
     * @param Article $article
     * @return \Illuminate\Support\Collection
     */
    public function create(Article $article)
    {
        return $article->getRelationalData();
    }


    /**
     * Save a new Article.
     *
     * @param Article $article
     * @param ArticleRequest $request
     * @return mixed
     */
    public function store(Article $article, ArticleRequest $request)
    {
        return $article->store($request);
    }


    /**
     * Update an article.
     *
     * @param Article $article
     * @param ArticleRequest $request
     * @return Article
     */
    public function update(Article $article, ArticleRequest $request)
    {
        $article->update($request->all());
        $article->syncArticleData($article, $request);
        return $article;
    }

    /**
     * Deactivate an article.
     *
     * @param Article $article
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function unPublish(Article $article, $id)
    {
        return $article->deactivate($id);
    }


    /**
     * Activate an article.
     *
     * @param Article $article
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function publish(Article $article, $id)
    {
        return $article->activate($id);
    }
}
