<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Upload image</title>

    </head>
    <body>

    <form method="POST" enctype="multipart/form-data">
        @csrf
        <label for="uploadImage">
            Upload Image <br>
        </label>
        <input type="file" name="image" id="uploadImage"><br>
        <button type="submit">Send</button>
    </form>

    </body>
</html>
