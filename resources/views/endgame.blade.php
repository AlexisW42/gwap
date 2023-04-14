@extends('layouts.game')

@section('content')
<div class="p-6 flex flex-col items-center text-gray-900 content-center">
    @if($game->ready)
    <h1 class="mt-3 mb-3 text-2xl font-semibold">Game finished!</h1>
    <table class="border border-indigo-300">
        <tr>
            <td></td>
            <td style="text-align: center;" class="p-2 border border-indigo-300 object-center"><img class="h-40" src="{{asset($game->pathImage1)}}"></td>
            <td style="text-align: center;" class="p-2 border border-indigo-300 text-center"><img class="h-40" src="{{asset($game->pathImage2)}}"></td>
            <td style="text-align: center;" class="p-2 border border-indigo-300 text-center"><img class="h-40" src="{{asset($game->pathImage3)}}"></td>
        </tr>
        <tr>
            <td class="p-2 border border-indigo-300">{{$game->username1}}</td>
            @foreach($data[0] as $words)
                <td class="p-2 border border-indigo-300">{{implode(', ', $words)}}</td>
            @endforeach
        </tr>
        <tr>
            <td class="p-2 border border-indigo-300">{{$game->username2}}</td>
            @foreach($data[1] as $words)
                <td class="p-2 border border-indigo-300">{{implode(', ', $words)}}</td>
            @endforeach
        </tr>
        <tr>
            <td class="p-2 border border-indigo-300">{{$game->username3}}</td>
            @foreach($data[2] as $words)
                <td class="p-2 border border-indigo-300">{{implode(', ', $words)}}</td>
            @endforeach
        </tr>
    </table>
    @else
        <h1 class="mt-3 mb-3 text-2xl font-semibold">This game has not finished!</h1>
    @endif
    <a href="{{ url('/dashboard') }}" class="mt-3 text-2xl font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Go to dashboard</a>
</div>

@endsection
