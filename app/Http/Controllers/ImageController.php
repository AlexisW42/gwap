<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
    public function index(){
        abort_if(Auth::user()->role != 'admin', 403);

        $images = Image::get();
        $imagesAndWords=[];
        foreach ($images as $image){
            $temp = [];
            $words = Word::where('pathImage', $image->path)->get();
            foreach ($words as $word){
                $temp = [...$temp, $word->word];
            }
            $imagesAndWords = [...$imagesAndWords, "$image->path"=>[...$temp]];
        }

        return view('list-images', ['images'=>$imagesAndWords]);
    }
    public function saveImage(Request $request) {
        $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);
        $image_path = $request->file('image')->store('images');
        //session()->flash('success', 'Image Upload successfully');
        $image = new Image;
        $image->path = $image_path;
        $image->save();
        return view('admin.dashboard');
    }

    public function getImages() {
        $images = Image::inRandomOrder()->take(3)->get();
        if (sizeof($images) >= 3) {
            return view('game', ['images' => $images]);
        }

        return 'There are not enough images on the server to play a game';
    }
}
