<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regester</title>
</head>

<body>
    <form action="/users/register" method="post">
        @csrf
        <input type="text" placeholder="Name" name="name">
        <input type="email" placeholder="Email" name="email">
        <input type="username" placeholder="Username" name="username">
        <input type="password" placeholder="passsword" name="password">
        <select name='sex'>
            <option value="M"> male</option>
            <option value="F"> Female</option>
        </select>
        <input type="number" placeholder="age" name="age">
        <input type="submit" value="register">
    </form>

</body>

</html>