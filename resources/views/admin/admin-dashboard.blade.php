<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('./css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('./css/comon.css') }}">
    <title>Dashboad</title>
</head>

<body>
    <div class="navgation flex between">

        <div class="user flex">
            <img src="{{ asset('./img/profile.png')}}" alt="user">
            <div>

                <h1> Admin</h1>
                <form action="/admin/logout" method="post">
                    @csrf
                    @method('DELETE')

                    <button> <img src="{{ asset('./img/logout.png') }}" alt="logout"> logout</button>
            </div>
            </form>
        </div>
        <div class="time">
            <p>
                controll center
            </p>

        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex admin">
        <form action="/admin/create-trainer" method="post" id="registrationForm">


            @error('email')<span class="error-message">{{ $message }}</span>@enderror
            @error('username')<span class="error-message">{{ $message }}</span>@enderror

            <h1 class="small">Create a tranner</h1>
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

        <form action="/admin/create-admin" method="post" id="registrationForm">


            @error('email')<span class="error-message">{{ $message }}</span>@enderror
            @error('username')<span class="error-message">{{ $message }}</span>@enderror

            <h1 class="small">Create an admin</h1>
            @csrf


            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" placeholder="Email" name="email" id="email">
                <small class="error"></small>
            </div>

            <div class="input-group">
                <label for="password">Create password</label>
                <input type="password" placeholder="Password" name="password" id="password">
                <small class="error"></small>
            </div>

            <input type="submit" value="Register" class="btn">
        </form>

    </div>






</body>

</html>