<html>
<head>
    <title>Hotmart Post</title>
</head>
<body>
    <form action="{{route('admin.formhotmart')}}" method="post">
        <input type="text" name="email" placeholder="email" />
        <input type="text" name="name" placeholder="name" />
        <input type="text" name="first_name" placeholder="first_name" />
        <input type="text" name="last_name" placeholder="last_name" />
        <input type="text" name="status" placeholder="status" />
        <input type="submit" value="Enviar">
    </form>
</body>
</html>