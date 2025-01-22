<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>

<body>
    <form action="/users/logout" method="post">
        @csrf
        @method("DELETE")
        <input type="submit" value="logout">
    </form>


    @if (session('success'))
        {{session('success')}}

    @endif

    @if (session('error'))
        {{session('error')}}

    @endif

    <form action="/users/save-workout" method="post">
        @csrf
        <input type="number" placeholder="workout id" name="workout_id">
        <input type="submit" value="save">
    </form>
    <h1> save plan </h1>
    <form action="/users/save-plan" method="post">

        @csrf
        <input type="number" placeholder="plan id" name="plan_id">
        <input type="submit" value="save">

    </form>



    update user plan

    <form action="/users/update-plan" method="post">
        @csrf
        <input type="number" placeholder="plan id" name='plan_id'>
        <input type="number" placeholder="worked dates" name='worked_dates'>
        <input type="number" placeholder="paued number" name='paued_number'>
        <input type="submit" value="submit">


    </form>
</body>

</html>