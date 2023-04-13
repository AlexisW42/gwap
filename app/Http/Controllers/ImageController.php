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
        return view('admin.dashboard');
    }

    public function getImages() {
        $images = Image::inRandomOrder()->take(3)->get();
        if (sizeof($images) >= 3) {
            return view('game', ['images' => $images]);
        }

        return 'There are not enough images in server to play a game';
    }
}
