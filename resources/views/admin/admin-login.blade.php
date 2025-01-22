<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin login</title>
</head>

<body>
    <form action="/admin/login" method="post">
        @csrf
        <input type="email" placeholder="email" name="email">
        <input type="password" placeholder="password" name="password">
        <input type="submit" value="login">
    </form>

</body>

</html>