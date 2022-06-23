<?php

namespace App\Http;

use App\Api\Service;

class Player
{

    private $sId;
    private $sBaseEndpoint;
    private $sGame;
    private $sLogo;
    
    public function __construct($sGame, $sId)
    {
        $this->sGame = $sGame;
        $aBaseEndpoints = [
            'nba' => env('NBA_API_ENDPOINT'),
            'rugby' => env('RUGBY_API_ENDPOINT')
        ];
        $aImageRoutes = [
            'nba' => '/images/players/nba/',
            'rugby' => '/images/players/allblacks/'
        ];
        $aLogos = [
            'rugby' => '/images/teams/allblacks.png',
            'nba' => '/images/teams/gsw.png'
        ];
        $aTitle = [
            'rugby' => 'All Blacks Rugby',
            'nba' => 'NBA BASKETBALL'
        ];
        $this->sTitle = $aTitle[$sGame];
        $this->sLogo = $aLogos[$sGame];
        $this->sImageRoute = $aImageRoutes[$sGame];
        $this->sBaseEndpoint = $aBaseEndpoints[$sGame];
        $this->sEndpointTail = $sId !== '' ? "id/$sId" : '';
    }

    public function get()
    {
        $aPlayers = $this->sGame === 'rugby' ? $this->getRugbyPlayes() : $this->getNbaPlayers();
        $aPlayers['title'] = $this->sTitle;
        $aPlayers['team_color'] = $aPlayers[0]['team_color'];

        return $aPlayers;
    }

    private function getRugbyPlayes()
    {
        $aPlayers = Service::get($this->sBaseEndpoint, $this->sEndpointTail);
        $aTempArray = [];
        foreach ($aPlayers as $sIndex => $aRow) {
            $aTempArray = $aRow;
            $aTempArray['height'] = $aTempArray['height'] . 'CM';
            $aName = explode(' ', $aRow['name']);            
            list($sFirstName, $sLastName) = [$aName[0], implode(' ', array_slice($aName, 1))];
            $aTempArray['first_name'] = $sFirstName;
            $aTempArray['last_name'] = $sLastName;
            $aTempArray['image'] = $this->getImageRoute($aRow['name']);
            $aTempArray['featured'] = collect([
                ['label' => 'Points', 'value' => $aRow['points']],
                ['label' => 'Games', 'value' => $aRow['games']],
                ['label' => 'Tries', 'value' => $aRow['tries']]
            ]);
            $aTempArray['team_logo'] = '/images/teams/allblacks.png';
            $aTempArray['team_color'] = 'black';
            $aPlayers[$sIndex] = $aTempArray;
            $aTempArray = [];
        }

        return $aPlayers;
    }

    private function getNbaPlayers()
    {
        $aPlayers = Service::get($this->sBaseEndpoint, $this->sEndpointTail);
        $aPlayersStats = Service::get(str_replace('.players','.stats', $this->sBaseEndpoint), $this->sEndpointTail);
        $aTempArray = [];
        foreach ($aPlayers as $sIndex => $aPlayer) {
            $aTempArray = $aPlayer;
            $aPlayerId = array_column($aPlayersStats, 'player_id');
            $aPlayerStats = $aPlayersStats[array_search($aPlayer['id'], $aPlayerId)];
            $aTempArray['featured'] = collect([
                ['label' => 'ASSISTS PER GAME', 'value' => round($aPlayerStats['assists'] / $aPlayerStats['games'], 1)],
                ['label' => 'POINTS PER GAME', 'value' => round($aPlayerStats['points'] / $aPlayerStats['games'], 1)],
                ['label' => 'REBOUNDS PER GAME', 'value' => round($aPlayerStats['rebounds'] / $aPlayerStats['games'], 1)],
            ]);
            $aTempArray['image'] = $this->getImageRoute(implode(' ', [$aPlayer['first_name'], $aPlayer['last_name']]));
            $aTempArray['height'] =  implode("'", [$aPlayer['feet'], $aPlayer['inches']]);

            $date1=date_create($aPlayer['birthday']);
            $date2=date_create(date("Y-m-d"));
            $aTempArray['age'] = date_diff($date1,$date2)->y;

            $aTempArray['team_logo'] = '/images/teams/' . strtolower($aPlayer['current_team']) . '.png';
            $aTempArray['team_color'] = $aPlayer['current_team'] === 'GSW' ? '#3939a8' : 'brown';
            $aPlayers[$sIndex] = $aTempArray;
            $aTempArray = [];
        }

        return $aPlayers;
    }

    private function getImageRoute($sPlayerName)
    {
        $sPlayerName = preg_replace('/\W+/', '-', strtolower($sPlayerName)) . '.png';        
        return $this->sImageRoute . $sPlayerName;
    }
}