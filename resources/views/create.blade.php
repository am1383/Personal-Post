<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Login </title>
</head>
<body>
    <h2> Create Account Page </h2>
    @if ($errors->any())
        @foreach($errors->all() as $error)
            {{ $error }} <br>
        @endforeach
        <br>
    @endif
   <form method = "post" action = "{{ route ('api.register') }}">
        @csrf
    <label for = "name"> Please Enter Name </label> <input type = "text" name = "name"> <br> <br>
    <label for = "email"> Please Enter Email </label> <input type = "text" name = "email"> <br> <br>
    <label for = "password">  Please Enter Password </label> <input type = "password"  name = "password"> <br>
    <input type = "submit">
    </form>
</body>
</html>
