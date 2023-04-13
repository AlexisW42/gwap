@extends('layouts.game')

@section('content')
    @if($game->endTime != null)
        <div id="timer"></div>
        <img id="image" src="" class="h-72"  alt=""><br>
        <form id="sendWord">
            @csrf
            <label class="block font-medium text-sm text-gray-700" for="word">Word</label>
            <input id="word" class="block mt-1 w-full" type="text" name="word" value="{{old('word')}}"><br>

            <div style="color: red" id="response"></div>
            <x-primary-button class="ml-3">
                {{ __('send') }}
            </x-primary-button>
        </form>

        <p id="result"></p>
	@elseif($game->endTime == null)
        <div class="text-center">
            <div role="status">
                <svg aria-hidden="true" class="inline w-32 h-32 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-indigo-900" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                </svg>
                <span class="sr-only">Loading...</span>
        </div>
            <div>Waiting for players</div>
            @else
                <div>This game is not available more, play a new game</div>
    @endif
@endsection

@section('script')
    @if($game->endTime != null)
    <script>
        let endDate = new Date('{{$game->endTime}}')
        let myDate = new Date()
        console.log(myDate)
        console.log(endDate)
        console.log(Math.floor((endDate-myDate)/1000))

        const images = ['{{$game->pathImage1}}',
            '{{$game->pathImage2}}',
            '{{$game->pathImage3}}'];
        let time = Math.floor((endDate-myDate)/1000);
        let image = 0
        $('#image').attr('src', `{{url('/')}}/${images[image]}`);
        let timeoutID = setInterval(setTimer, 1000);
		setTimer()
        function setTimer(){
            time--
            minutes = (time-(time%60))/60;
            seconds = time%60;
            let str = `${minutes}:${seconds<10?'0':''}${seconds}`

            if(time<=120 && image==0){
                image++
                $('#image').attr('src', `{{url('/')}}/${images[image]}`);

            }else if(time<=60 && image==1){
                image++
                $('#image').attr('src', `{{url('/')}}/${images[image]}`);
            }else if(time<=0){
                clearTimeout(timeoutID);
				time=0; str='0:00'
                end();
			}
            $('#timer').text(str);
        }

        $("#sendWord").submit(() => {
            let the_game_id = 1;
            $('#response').empty()

            $.ajax({
                method: "post",
                url: '{{url('/send-word')}}',
                dataType: 'JSON',
                data: {
                    _token: '{{csrf_token()}}',
                    word: $('#word').val(),
                    game_id: {{$game->id}},
                    pathImage: images[image],
                },
                success: function (data) {
                    console.log("sended");
                    console.log(data);
                    $('#word').val('')
                },
                error: function( data ) {
                    if( data.status === 422 ) {
                        console.log("response ", $.parseJSON(data.responseText).errors)
                        if($.parseJSON(data.responseText).errors){
                            let errors = $.parseJSON(data.responseText);
                            $('#response').addClass("alert alert-danger");
                            $.each(errors, function (key, value) {
                                if($.isPlainObject(value)) {
                                    $.each(value, function (key, value) {
                                        console.log(key+ " " +value);
                                        $('#response').show().append(value+"<br/>");
                                    });
                                }
                            });
                        } else {
                            console.log(data.message)
                            $('#response').show().append($.parseJSON(data.responseText).message+"<br/>");
                            $('#word').val('')
                        }
                    }
                }
            });
            return false;
        });

        function end(){
            //url to redirect at the end of game
            window.location.href = '{{url('/player_dashboard')}}';
        }
    </script>
    @endif
@endsection
