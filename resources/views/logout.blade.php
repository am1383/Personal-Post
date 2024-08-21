<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log Out</title>
</head>
<body>
    <form method = "post" action = "{{ route ('logout.api') }}">
        @csrf
        <input type ="submit">
    </form>
</body>
</html>
