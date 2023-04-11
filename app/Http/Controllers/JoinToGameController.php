<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JoinToGameController extends Controller
{
    public function __invoke(){
        $games = Game::where('username2', null)
                        ->orwhere('username3', null)
                        ->take(1)->get();
        $images = Image::inRandomOrder()->take(3)->get();
        if(sizeof($games) == 0 && sizeof($images) >= 3)
        {
            $game = new Game;
            $game->username1 = Auth::user()->username;
            $game->pathImage1 = $images[0]->path;
            $game->pathImage2 = $images[1]->path;
            $game->pathImage3 = $images[2]->path;
            $game->save();
        } elseif (sizeof($games)!=0 && sizeof($images) >= 3){
            $game = $games[0];
            if($game->username2==null){
                $game->username2 = Auth::user()->username;
            } else {
                $game->username3 = Auth::user()->username;
                $game->ready = true;
                $timestamp = mktime(date("H"), date("i")+3, date("s")+15, date("m") , date("d"), date("Y"));
                $game->endTime = date("Y-m-d H:i:s", $timestamp);
            }
            $game->save();
        }
        return view('test1', ['game'=>$game]);
    }
}
