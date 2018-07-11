<?php

namespace App\Traits\Article;

use App\Tag;
use App\Club;
use App\Staff;
use App\Player;
use App\Article;
use App\Category;
use App\Competition;

trait ManagingDataCollections {



    /**
     * Make an extended article data collection
     *
     * @param $id
     * @param $page
     * @return \Illuminate\Support\Collection
     */
    public function articleData ($id, $page)
    {
        $article = Article::find($id);

        return collect([
            'previous' => Article::where('id', '<', $id)->orderBy('id','desc')->first(),
            'next' => Article::where('id', '>', $id)->orderBy('id','asc')->first(),

        ])->merge($article)->merge($this->getRelationalData())->merge($article->ArticleRelatedData($page));
    }

    /**
     * Get a collection of instances of all models with which a current article related
     *
     * @param $page
     * @return \Illuminate\Support\Collection
     */
    public function ArticleRelatedData($page)
    {
        if ($page == 'edit') {
            $field = 'id';
        } else {
            $field = 'name';
        }
        return collect([
            'categories' => $this->categories()->pluck($field),
            'tags' => $this->tags()->pluck('name'),
            'competitions' => $this->competitions()->pluck($field),
            'players' => $this->players()->pluck($field),
            'clubs' => $this->clubs()->pluck($field),
            'staff' => $this->staff()->pluck($field),
        ]);
    }



    /**
     * Get a collection of instances of all models with which an article can be related
     *
     * @return \Illuminate\Support\Collection
     */
    public function getRelationalData()
    {
        return collect([
            'categoriesList' => Category::getCategoriesListFromCache(),
            'tagsList' => Tag::getTagsListFromCache(),
            'competitionsList' => Competition::getCompetitionsListFromCache(),
            'playersList' => Player::getPlayersListFromCache(),
            'clubsList' => Club::getClubsListFromCache(),
            'staffList' => Staff::getStaffListFromCache(),
        ]);
    }
}