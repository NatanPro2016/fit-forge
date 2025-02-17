<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get started to ajuster</title>
    <meta name="description" content="get started to ajuster">
    <link rel="stylesheet" href="{{ asset('./css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('./css/comon.css') }}">

    <link rel="icon" href="{{ asset('./img/logo.png') }}">
</head>

<body data-page="get-started">
    <nav class="flex between items-center">
        <a class="logo flex items-center" href="/">
            <img src="./img/logo.png" alt="logo" />
            Ajuster
        </a>

        <a href="/" class="goback">
            <img src="./img/go-back.png" alt="">
            Go back
        </a>
    </nav>
    <section class="get-started">
        <div class="flex">
            <a href="/users/register" class="flex flex-col">
                <img src="./img/solar_running-bold.png" alt="Trainee">
                <h2> Trainee</h2>
                <p>
                    I am a trainee (client) wanna tarn on fit forge app
                </p>
            </a>
            <a href="/trainer/login" class="flex flex-col">

                <img src="./img/logo-2.png" alt="Trainer" />
                <h2> Trainer</h2>
                <p>
                    I am a trainer(instructor) wanna tarn clients on fit forge app
                </p>
            </a>

        </div>


    </section>



</body>

</html>