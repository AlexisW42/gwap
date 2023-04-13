@extends('layouts.game')

@section('content')
    <div class="p-6 grid grid-flow-row">
    @foreach($images as $path => $words)
        <div class="grid grid-cols-2 p-6 my-2 mx-3 content-center border border-indigo-200">
            <img class="h-52 self-start justify-self-center	" src="{{asset($path)}}">
            <div class="p-4">
                <p class="text-lg font-semibold" >Words:</p>
                @if(!sizeof($words)==0)
                {{implode(', ', $words)}}.
                @else
                    There are no words yet.
                @endif
            </div>
        </div>
    @endforeach
    </div>
@endsection
