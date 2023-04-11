<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GWAP game</title>
    <script src="{{asset('jquery-3.6.4.min.js')}}"></script>
</head>
<body>

<div id="timer">2:59</div>
<img id="image" src="" height="300px" alt=""><br>
<form id="sendWord">
    @csrf
    <label for="word">Word</label> <br>
    <input type="text" name="word" id="word" value="{{old('word')}}"><br>

    <div style="color: red" id="response"></div>

    <button type="submit">send</button>
</form>

<p id="result"></p>

</body>
<script>
    const images = ['{{$game->pathImage1}}',
                    '{{$game->pathImage2}}',
                    '{{$game->pathImage3}}'];
    let time = 180;
    let image = 0
    $('#image').attr('src', `{{url('/')}}/${images[image]}`);
    let timeoutID = setInterval(setTimer, 500);
    function setTimer(){
        time--
        minutes = (time-(time%60))/60;
        seconds = time%60;
        let str = `${minutes}:${seconds}`

        $('#timer').text(str);
        if(time===120){
            image++
            $('#image').attr('src', `{{url('/')}}/${images[image]}`);

        }
        if(time===60){
            image++
            $('#image').attr('src', `{{url('/')}}/${images[image]}`);
        }
        if(time==0)
        clearTimeout(timeoutID);
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
</script>
</html>
