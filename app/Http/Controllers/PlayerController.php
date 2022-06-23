<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use App\Http\Player;

class PlayerController extends Controller
{
        
    public function get($sGame, $sId = '')
    {
        $this->oPlayer = new Player($sGame, $sId);
        return $this->oPlayer->get();
    }

    public function view($sGame, $sId = '')
    {
        $aAllPlayers = $this->get($sGame, $sId); 
        return view('players',['aAllPlayers' => $aAllPlayers]);
    }
}
