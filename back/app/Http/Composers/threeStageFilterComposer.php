<?php namespace App\Http\Composers;

use App\Club;
use App\Player;
use App\Competition;
use App\Helpers\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class threeStageFilterComposer {


    public function compose($view)
    {
        /**
         * If the request includes the content sorting parameters
         * by belonging to certain competitions, clubs or players,
         * we try to find the names of these competitions / clubs / players in the database
         * and transfer them to the sorting Vue component (called 'threeStageContentFilter')
         */

        $competitionName = $unPickedCompetitionValue = Lang::get('threeStageFilter.unPickedCompetitionValue');
        $clubName = $unpickedClubValue = Lang::get('threeStageFilter.unpickedClubValue');
        $playerName = $unpickedPlayerValue = Lang::get('threeStageFilter.unpickedPlayerValue');

        $competitionSlug = 'all';
        $clubSlug = 'all';
        $playerSlug = 'all';

        if($view->request->co) {
            if (Competition::where('slug', $view->request->co)->exists()) {
                $competitionSlug = $view->request->co;
                $competitionName = Competition::where('slug', $view->request->co)->value('name');
            }
        }

        if($view->request->club) {
            if (Club::where('slug', $view->request->club)->exists()) {
                $clubSlug = $view->request->club;
                $clubName = Club::where('slug', $view->request->club)->value('name');
            }
        }

        if($view->request->pl) {
            if (Player::where('slug', $view->request->pl)->exists()) {
                $playerSlug = $view->request->pl;
                $playerName = Player::where('slug', $view->request->pl)->value('name');
            }
        }

        if ($view->request->co || $view->request->club || $view->request->pl) {
            $isFiltered = true;
        } else {
            $isFiltered = false;
        }

        /**
         * Transfer variables to the main page of the model for which the composer is used
         */

        $view->with([
            'competitions' => Api::get_competitions(),
            'clubsList' => Api::get_clubs($view->request->co),
            'playersList' => Api::get_players($view->request->club),

            'competitionSlug' => $competitionSlug,
            'competitionName' => $competitionName,

            'clubSlug' => $clubSlug,
            'clubName' => $clubName,

            'playerSlug' => $playerSlug,
            'playerName' => $playerName,

            'unPickedCompetitionValue' => $unPickedCompetitionValue,
            'unpickedClubValue' => $unpickedClubValue,
            'unpickedPlayerValue' => $unpickedPlayerValue,

            'isFiltered' => $isFiltered,

            'resetBtnValue' => Lang::get('threeStageFilter.resetBtnValue'),
            'searchBtnValue' => Lang::get('threeStageFilter.searchBtnValue'),

            'fetchClubsErrMsg' => Lang::get('threeStageFilter.fetchClubsErrMsg'),
            'fetchPlayersErrMsg' => Lang::get('threeStageFilter.fetchPlayersErrMsg'),
            'fetchDataErrMsg' => Lang::get('threeStageFilter.fetchDataErrMsg'),
            'exceededRequestsMsg' => Lang::get('threeStageFilter.exceededRequestsMsg'),
        ]);
    }
}