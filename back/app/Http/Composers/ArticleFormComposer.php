<?php namespace App\Http\Composers;

use App\Tag;
use App\Club;
use App\Staff;
use App\Player;
use App\Category;
use App\Competition;

class ArticleFormComposer {

    public function compose($view)
    {
        $view->with([
            'tags' => Tag::pluck('name', 'name'),
            'clubs' => Club::pluck('name', 'id'),
            'staff' => Staff::pluck('name', 'id'),
            'players' => Player::pluck('name', 'id'),
            'categories' => Category::where('model', 'article')->pluck('name', 'id'),
            'competitions' => Competition::pluck('name', 'id')
        ]);
    }
}