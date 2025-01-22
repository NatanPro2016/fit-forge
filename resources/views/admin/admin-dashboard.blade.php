<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboad</title>
</head>

<body>

    admin


    <form action="/admin/logout" method="post">
        @csrf
        @method('DELETE')
        <input type="submit" value="logout">
    </form>
</body>

</html>