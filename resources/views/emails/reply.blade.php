<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        body, p, div {
            margin: 0;
            padding: 0;
            line-height: 1.5;
            text-align: left;
        }
    </style>
</head>
<body>
    <p>Hello, {{$name}}</p>

    <div style="white-space: pre-wrap; font-family: Arial, sans-serif;">
        {!! trim($userMessage) !!}
    </div>

    <p>Best regards,<br>MCL Team</p>
</body>
</html>
