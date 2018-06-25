<?php namespace App\Helpers;

use App\Club;
use App\Player;
use App\Competition;
use Illuminate\Http\Request;
class Api {

    /**
     * Get all active competitions.
     *
     * @return array
     */
    public static function get_competitions()
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