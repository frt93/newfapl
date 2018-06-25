<?php namespace App\Http\Controllers;

use App\Tag;
use App\Article;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;


class ArticlesController extends Controller
{
    /**
     * Create a new Article controller instance.
     *
     * ArticlesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['create', 'edit', 'deactivate', 'activate']]);
    }

    /**
     * Show all articles matching the query on /articles page.
     *
     * @param Request $request
     * @return Response
     */

    public function index(Request $request)
    {
        $articles = Article::latest('published_at')->published($request)->paginate(10);
        return view('articles.index', compact('articles', 'request'));
    }

    /**
     * Show a single article.
     *
     * @param Article $article
     * @return Response
     */

    public function show(Article $article)
    {
        $previous = Article::where('id', '<', $article->id)->orderBy('id','desc')->first();
        $next = Article::where('id', '>', $article->id)->orderBy('id','asc')->first();
        return view('articles.show', compact('article', 'next', 'previous'));
    }

    /**
     * Show the page to create a new Article.
     *
     * @return Response
     */

    public function create()
    {
        return view('articles.create');
    }

    /**
     * Save a new Article.
     *
     * @param ArticleRequest $request
     * @return Response
     */

    public function store(ArticleRequest $request)
    {
        $this->createArticle($request);

        flash()->success('Ваша статья добавлена');
        return redirect('articles');
    }

    /**
     * Edit an existing article.
     *
     * @param Article $article
     * @return Response
     */

    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    /**
     * Update an article.
     *
     * @param Article $article
     * @param ArticleRequest $request
     * @return Response
     */

    public function update(Article $article, ArticleRequest $request)
    {
        dd($article);
        $article->update($request->all());
        $this->syncArticleData($article, $request);

        flash()->success('Ваша статья обновлена');
        return redirect()->action('ArticlesController@show', [$article->id]);
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
        return redirect('articles');
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
        return redirect('articles');
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
}
