@extends('layouts.game')

@section('content')
    <div class="p-6 flex flex-col items-center text-gray-900 content-center">
    <form method="POST" enctype="multipart/form-data">
        @csrf
        <label for="uploadImage">
            Upload Image <br>
        </label>
        <input type="file" name="image" id="uploadImage"><br>
        <x-primary-button class="mt-4">
                {{ __('send') }}
        </x-primary-button>
    </form>
    </div>
@endsection
