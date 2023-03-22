<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function saveImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);
        $image_path = $request->file('image')->store('images');
        //session()->flash('success', 'Image Upload successfully');
        $image = new Image;
        $image->path = $image_path;
        $image->save();
        return dump($request);
    }

    public function getImages()
    {
        $images = Image::get();

        if (sizeof($images) >= 3) {
            $rand_keys = $this->numbersWithoutRep(sizeof($images)-1);
            return view('game', ['images' => [$images[$rand_keys[0]], $images[$rand_keys[1]], $images[$rand_keys[2]]]]);
        }

        return 'There are not enough images in server to play a game';
    }

    private function numbersWithoutRep($max): array
    {
        $numbers = [rand(0, $max)];
        while (sizeof($numbers) < 3) {
            $value = rand(0, $max);
            $bool = false;
            foreach ($numbers as $number) {
                if($number== $value)
                    $bool = true;
            }
            if(!$bool){
                array_push($numbers, $value);
            }
        }
        return $numbers;
    }
}
