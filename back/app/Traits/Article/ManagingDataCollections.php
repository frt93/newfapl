<?php

namespace App\Traits\Article;

use App\Tag;
use App\Club;
use App\Staff;
use App\Player;
use App\Article;
use App\Category;
use App\Competition;
use Illuminate\Http\Request;

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

        ])->merge($article)->merge($article->ArticleRelatedData($page));
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
        $relatedData = collect([
            'categories' => $this->categories()->pluck($field),
            'tags' => $this->tags()->pluck('name'),
            'competitions' => $this->competitions()->pluck($field),
            'players' => $this->players()->pluck($field),
            'clubs' => $this->clubs()->pluck($field),
            'staff' => $this->staff()->pluck($field),
        ]);

        if ($page == 'edit') {
            return $relatedData->merge($this->getRelationalData());
        }

        return $relatedData;
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

    /**
     * Get all active competitions.
     *
     * @return array
     */
    public function get_competitions()
    {
        $unPickedCompetitionValue = 'Все турниры';

        $competitionList = collect([
            ['slug' => 'all', 'name' => $unPickedCompetitionValue]
        ]);

        $competitions =  Competition::all('slug', 'name');
        foreach ($competitions as $competition) {
            $competitionList->push(['slug' => $competition->slug, 'name' => $competition->name]);
        }

        return $competitionList;
    }

    /**
     * Get a list of clubs participating in the tournament this season.
     *
     * @param request
     * @return array
     */
    public static function get_clubs($request)
    {
        $unpickedClubValue = 'Все клубы';

        $clubsList = collect([
            ['slug' => 'all', 'name' => $unpickedClubValue]
        ]);

        if ($request) {
            if (Competition::where('slug', $request)->exists()) {
                $clubs = Club::all('slug', 'name');
                foreach ($clubs as $club) {
                    $clubsList->push(['slug' => $club->slug, 'name' => $club->name]);
                }
            }
        }

        return $clubsList;
    }

    /**
     * Get a list of players, declared for the club to participate in the tournament in the current season
     *
     * @param request
     * @return array
     */
    public static function get_players($request)
    {
        $unpickedPlayerValue = 'Все игроки';

        $playersList = collect([
            ['slug' => 'all', 'name' => $unpickedPlayerValue]
        ]);

        if ($request) {
            if (Club::where('slug', $request)->exists()) {
                $players = Player::all('slug', 'name');
                foreach ($players as $player) {
                    $playersList->push(['slug' => $player->slug, 'name' => $player->name]);
                }
            }
        }

        return $playersList;
    }
}