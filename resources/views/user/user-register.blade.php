<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regester</title>
    <meta name="description" content="Regster to ajuster">
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

        <a href="/users/login">I already have an account login </a>
    </nav>
    <div class="contaner">
        <h1>
            Create account
        </h1>
        <p class="muted">
            Fill in the data for profile. It will take a couple of minutes.
            You only need a passport
        </p>
        <div class="input-terms-of-use">

            <input type="checkbox" name="agree" id="agree">
            <label for="agree" class="flex"> I agree with <a href="/">Terms of use</a></label>
        </div>

        <form action="/users/register" method="post" id="registrationForm">
            @error('email')<span class="error-message">{{ $message }}</span>@enderror
            @error('username')<span class="error-message">{{ $message }}</span>@enderror

            <h1 class="small">Personal data</h1>
            @csrf

            <div class="input-group">
                <label for="name">Name</label>
                <input type="text" placeholder="Name" name="name" id="name">
                <small class="error"></small>
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" placeholder="Email" name="email" id="email">
                <small class="error"></small>
            </div>
            <div class="input-group">
                <label for="username">Create username</label>
                <input type="text" placeholder="Username" name="username" id="username">
                <small class="error"></small>
            </div>
            <div class="input-group">
                <label for="password">Create password</label>
                <input type="password" placeholder="Password" name="password" id="password">
                <small class="error"></small>
            </div>
            <div class="input-group">
                <label for="sex">Sex</label>
                <select name="sex" id="sex">
                    <option value="">Select</option>
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                </select>
                <small class="error"></small>
            </div>
            <div class="input-group">
                <label for="age">Age</label>
                <input type="number" placeholder="Age" name="age" id="age">
                <small class="error"></small>
            </div>
            <input type="submit" value="Register" class="btn">
        </form>

    </div>


</body>

</html>