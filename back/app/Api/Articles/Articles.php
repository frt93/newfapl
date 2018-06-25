<?php

namespace App\Api\Articles;

use App\Article;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;


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
        $article = Article::where('pinned', '=', 1)->orderBy('id','asc')->first();
        return $article;
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
            'cat' => $article->categories,
            'tags' => $article->tags,
            'players' => $article->players,
            'clubs' => $article->clubs,
            'previous' => Article::where('id', '<', $id)->orderBy('id','desc')->first(),
            'next' => Article::where('id', '>', $id)->orderBy('id','asc')->first()

        ]);
    }


    /**
     * Deactivate an article.
     *
     * @param Article $id
     * @return response
     */

    public function deactivate($id)
    {
        Article::where('id', $id)->update(['published' => false]);
        return response()->json([
            'value' => 0
        ]);
    }

    /**
     * Activate an article.
     *
     * @param Article $id
     * @return response
     */

    public function activate($id)
    {
        Article::where('id', $id)->update(['published' => true]);
        return response()->json([
            'value' => 1
        ]);
    }

    public function updateArticle(Article $article, ArticleRequest $request)
    {
        $article->update($request->all());
    }
}
