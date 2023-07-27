<!DOCTYPE html>
<html>
<head>
    <title>Please activate your account!</title>
</head>
<body>
    <h1>Please activate your account!</h1>
    <p>Dear {{$Data["Username"]}},<br>Thank you for registering.<br>Please activate your account by clicking the following link:<br><a href="{{route('verify')}}?verifytoken={{$Data["Token"]}}&username={{$Data["Username"]}}"></a>{{route('verify')}}?verifytoken={{$Data["Token"]}}&username={{$Data["Username"]}}</p>
    <br>
    Kind Regards,
    GameCode64
</body>
</html>