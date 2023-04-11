<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SendWordController extends Controller
{
    public function __invoke(Request $request){
        $request->validate([
            'word' => 'required|min:4|max:255',
        ]);
        $exist = Word::where('username', Auth::user()->username)->where('word', $request->word)->doesntExist();
        if($exist){
            $word = new Word;
            $word->game_id = $request->game_id;
            $word->username = Auth::user()->username;
            $word->pathImage = $request->pathImage;
            $word->word = $request->word;
            $word->save();
            return $request;
        }else{
            return abort(422, 'The word was already sended') ;
        }
    }
}
