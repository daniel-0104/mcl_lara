<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h4>If you have a request to reset your password, please click on the link below to reset your password.</h4>

    <a href="{{ route('validate#token',['token' => $token]) }}">Click Here</a>
</body>
</html>

