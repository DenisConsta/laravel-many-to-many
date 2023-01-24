<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href=" {{ Vite::asset('resources/scss/styles/404.scss') }} ">
    @vite('resources/js/app.js')
    <title>404</title>
</head>

<body>
    <div class="text">
        <h2 class="display-1 fw-bolder mb-5">404</h2>
        <a href=" {{route('home')}} " class="my-btn glow-on-hover">Back To Home</a>
    </div>

    <div class="astronaut">
        <img src="https://images.vexels.com/media/users/3/152639/isolated/preview/506b575739e90613428cdb399175e2c8-space-astronaut-cartoon-by-vexels.png"
            alt="" class="src">
    </div>

</body>
<script src=" {{ Vite::asset('resources/js/page404.js') }} "></script>

</html>
