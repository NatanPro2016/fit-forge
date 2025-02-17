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
        <a href="/users/login">I am a user </a>
    </nav>
    <div class="contaner">
        <h1>Login Trainer </h1>

        <form action="/trainer/login" method="post">
            @csrf
            <div class="input-group">
                <label for="email"> email</label>
                <input type="email" name="email" placeholder="email">
            </div>
            <div class="input-group">
                <label for="password"> password</label>

                <input type="password" name="password" placeholder="password">
            </div>
            <input type="submit" value="login" class="btn">
        </form>
    </div>
</body>

</html>