<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JoinToGameController extends Controller
{
    public function __invoke(Request $request){
        $games = Game::where('username2', null)
                        ->orwhere('username3', null)
                        ->take(1)->get();
        $images = Image::inRandomOrder()->take(3)->get();
        if(sizeof($games) == 0 && Game::query()->where('ready', false)
				->where(function ($query) {
               			$query->where('username1', Auth::user()->username)
                    	 ->orWhere('username2', Auth::user()->username)
					   	 ->orWhere('username3', Auth::user()->username);
           })->exists()){
            $games = Game::query()->where('ready', false)
                ->where(function ($query) {
                    $query->where('username1', Auth::user()->username)
                        ->orWhere('username2', Auth::user()->username)
                        ->orWhere('username3', Auth::user()->username);
                })->first();
            return view('play', ['game'=>$games, 'valid'=>$this->getDates($games), 'message'=>'playing same game']);
        }
        if(sizeof($games) == 0 && sizeof($images) >= 3)
        {
            $game = new Game;
            $game->username1 = Auth::user()->username;
            $game->pathImage1 = $images[0]->path;
            $game->pathImage2 = $images[1]->path;
            $game->pathImage3 = $images[2]->path;
            $game->save();
        } elseif (sizeof($games)!=0 && sizeof($images) >= 3 && !$this->isAlreadyInGame($games[0])){
            $game = $games[0];
            if($game->username2==null){
                $game->username2 = Auth::user()->username;
            } else {
                $game->username3 = Auth::user()->username;
                $timestamp = mktime(date("H"), date("i")+3, date("s")+2, date("m") , date("d"), date("Y"));
                $game->endTime = date("Y-m-d H:i:s", $timestamp);
            }
            $game->save();
        }elseif ($this->isAlreadyInGame($games[0])){
            return view('play', ['game'=>$games[0], 'message'=>'You are on the game already', 'valid'=>$this->getDates($games[0])]);
        }elseif (sizeof($images) < 3){
            return 'There are not enough images in server to play a game';
        }

        return view('play', ['game'=>$game, 'valid'=>$this->getDates($game)]);
    }

    public function isAlreadyInGame(Game $game){
        if(((Auth::user()->username == $game->username1) ||
           (Auth::user()->username == $game->username2) ||
           (Auth::user()->username == $game->username3))&&$game->ready==false)
           return true;
        return false;
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
