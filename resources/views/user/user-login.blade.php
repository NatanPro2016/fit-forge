<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <meta name="description" content="Login to ajuster">
    <link rel="stylesheet" href="{{ asset('./css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('./css/comon.css') }}">

    <link rel="icon" href="{{ asset('./img/logo.png') }}">
    <script src="{{ asset('./js/inputvaldation.js') }}" defer></script>
</head>

<body>
    <nav class="flex between items-center">
        <a class="logo flex items-center" href="/">
            <img src="{{ asset('./img/logo.png') }}" alt="logo" />
            Ajuster
        </a>
        <a href="/users/register">I don't have an account register </a>
    </nav>
    <div class="contaner">
        <h1>Login</h1>
        <form action="/users/login" method="post">
            @csrf

            <div class="input-group">
                <label for="email"> email</label>
                <input type="email" placeholder="email" name="email" id="email">
            </div>
            <div class="input-group">
                <label for="password"> password</label>

                <input type="password" placeholder="password" name="password" id="password">
            </div>
            <input type="submit" value="login" class="btn">
        </form>

    </div>


</body>

</html>