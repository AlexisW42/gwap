<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Upload image</title>

</head>
<body>
@foreach($images as $image)
    <img src="{{ asset($image->path)}}" height="300px" alt=""><br>
@endforeach

</body>
</html>
