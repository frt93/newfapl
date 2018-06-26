<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Models\Articles;
use App\Helpers\Api;
use Illuminate\Http\Request;


class ApiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Api Controller
    |---------------------------------------------------------s-----------------
    |
    | This controller handles all user's API requests
    | The controller uses a trait to conveniently provide its functionality to your applications.
    |
    */

    use Articles;

    /**
     * Create a new Api controller instance.
     *
     * ArticlesController constructor.
     */
    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    }

    public function index(Request $request) {
        if ($request->getclubslist) {
            return Api::get_clubs($request->getclubslist);
        }

        if ($request->getplayerslist) {
            return Api::get_players($request->getplayerslist);
        }
    }

    /**
     * Get all published articles matching the query.
     * ПОтом убрать
     * @param Request $request
     * @return array
     */
    public function articles(Request $request)
    {
        $articles = Article::latest('published_at')->published($request)->paginate(10);
        return response()->json([
            'lastpage' => $articles->lastPage(),
            'content' => view('articles.partials.article', compact('articles'))->render()
        ]);
    }

}

