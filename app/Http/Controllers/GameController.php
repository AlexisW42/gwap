<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Word;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function show(Game $game){
        $this->getDates($game);
        $data = [$this->words($game, $game->username1)];
        $data = [...$data, $this->words($game, $game->username2)];
        $data = [...$data, $this->words($game, $game->username3)];

        return view('endgame', ['game'=>$game, 'data'=>[...$data]]);
    }

    public function words($game, $player)
    {
        $words = [];
        $words1 = Word::where('game_id', $game->id)->where('pathImage', $game->pathImage1)->where('username', $player)->get();
        $words2 = Word::where('game_id', $game->id)->where('pathImage', $game->pathImage2)->where('username', $player)->get();
        $words3 = Word::where('game_id', $game->id)->where('pathImage', $game->pathImage3)->where('username', $player)->get();

        $temp = [];
        foreach ($words1 as $word){
            $temp = [...$temp, $word->word];
        }
        $words=["image1"=>$temp]; $temp = [];

        foreach ($words2 as $word){
            $temp = [...$temp, $word->word];
        }
        $words=[...$words, "image2"=>$temp]; $temp = [];

        foreach ($words3 as $word){
            $temp = [...$temp, $word->word];
        }
        $words=[...$words, "image3"=>$temp]; $temp = [];

        return $words;
    }

    public function getDates(Game $game) {
        $endTime = new \DateTime($game->endTime);
        $currentTime = new \DateTime('now');

        if($endTime>=$currentTime&&$endTime==null)
            return true;
        if($game->endTime!=null&&$endTime<=$currentTime){
            $game->ready = true;
            $game->save();
        }
        return false;
    }
}
