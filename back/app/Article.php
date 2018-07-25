<?php namespace App;

use Carbon\Carbon;
use App\Http\Requests\ArticleRequest;

use Illuminate\Support\Facades\Redis;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Article\Scopes;
use App\Traits\Article\Relations;
use App\Traits\Article\ManagingDataCollections;



class Article extends Model
{
    use Relations, ManagingDataCollections, Scopes;

    protected $fillable = [
        'title',
        'excerpt',
        'body',
        'published_at',
        'author',
        'pinned'
    ];

    protected $dates = ['published_at'];


    /**
     * Get all published articles matching the query.
     *
     * @param $request
     * @return mixed
     */
    public function getArticles($request) {
        $articles = Article::latest('published_at')->published($request)->paginate(3);
        $filter = collect ([
            "filtersData" => collect ([
                "co" => $this->get_competitions(),
                "club" => $this->get_clubs($request->co),
                "pl" => $this->get_players($request->club),
                "picked" => $this->picked_params($request),
                "defaults" => collect([
                    "co" => "Все турниры",
                    "club" => "Все клубы",
                    "pl" => "Все игроки"
                ])
            ])
        ]);

        return $filter->merge($articles);
    }

    /**
     * Get pinned article
     *
     * @return mixed
     */
    public function pinned()
    {
        if( !Redis::exists('pinnedArticle') ) {
            $article = Article::where('pinned', '=', 1)->orderBy('id','asc')->first();
            $article->ArticleRelatedData('show');
            Redis::set('pinnedArticle', $article);
        }
        return Redis::get('pinnedArticle');
    }

    /**
     * Store an article
     *
     * @param ArticleRequest $request
     * @return mixed
     */
    public function store(ArticleRequest $request) {
        $article = User::where('id', '=', 1)
                        ->first()
                        ->articles()
                        ->create($request->all());
        $this->syncArticleData($article, $request);
        return $article;
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
     * When updating the article, let's check her pinned status.
     * If it's pinned - we cache her, then search for the previous pinned article (if it's not she herself)
     * and deprive her of this status.
     */
    public function checkPinnedStatusOnUpdate ()
    {
        if ( $this->pinned == 1 ) {
            Redis::set('pinnedArticle', $this);

            $previousPinnedArticle = Article::where('id', '<>', $this->id)
                    ->where('pinned', '=', 1)
                    ->orderBy('id','asc')
                    ->first()
                    ;

            if ($previousPinnedArticle) {
                $previousPinnedArticle->update(['pinned' => 0]);
            }
        }
    }

    public function activate($id)
    {
        $this->where('id', $id)->update(['published' => true]);
        return response()->json([
            'value' => true
        ]);
    }

    public function deactivate($id)
    {
        $this->where('id', $id)->update(['published' => false]);
        return response()->json([
            'value' => false
        ]);
    }
}
