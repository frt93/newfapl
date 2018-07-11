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
     */
    public function store(Article $article, ArticleRequest $request)
    {
        $article->store($request);
    }

    /**
     * Update an article.
     *
     * @param Article $article
     * @param ArticleRequest $request
     */

    public function update(Article $article, ArticleRequest $request)
    {
        $article->update($request->all());
        $article->syncArticleData($article, $request);
    }

    /**
     * Deactivate an article.
     *
     * @param Article $article
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function deactivate(Article $article, $id)
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
    public function activate(Article $article, $id)
    {
        return $article->activate($id);
    }
}
