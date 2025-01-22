<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Fit forge" />
    <link rel="stylesheet" href="{{ asset('./css/styles.css') }}">
    <link rel="icon" href="{{ asset('./img/logo.png') }}">


    <title>Fit forge</title>
</head>

<body>
    @auth
        <p> loged in</p>

    @else

        <nav class="flex between items-center">
            <a class="logo flex items-center" href="/">
                <img src="./img/logo.png" alt="logo" />
                Fit forge
            </a>
            <ul class="flex muted items-center">
                <li>
                    <a href="#">Home</a>
                </li>
                <li>
                    <a href="#">About</a>
                </li>
                <li>
                    <a href="#">info</a>
                </li>
                <li>
                    <a href="#">Get Started</a>
                </li>
            </ul>
            <a href="/get-started" class="btn">Login</a>
        </nav>
        <section class="hero flex flex-col">
            <div class="content flex between items-center">
                <div class="text flex flex-col">
                    <h1>
                        The best app for tracking and tanning together with professionals
                    </h1>
                    <p>working sharing our achievement together</p>
                    <a href="" class="btn"> Get started</a>
                </div>
                <img src="./img/graph.png" alt="" />
            </div>
            <div class="cards flex between">
                <img src="./img/increase.png" alt="" />
                <img src="./img/400.png" alt="" />
                <img src="./img/70.png" alt="" />
            </div>
        </section>
        <section class="features flex flex-col justfy-center items-center">
            <h1>Features</h1>
            <p class="small muted">Our app provides this information</p>
            <div class="flex cards">
                <div class="card flex flex-col">
                    <img src="./img/solar_running-bold.png" alt="" />
                    <h2>Tracking</h2>
                    <p class="muted">
                        The app tracks and saves you daily progress of your achvement
                    </p>
                </div>

                <div class="card flex flex-col">
                    <img src="./img/share.png" alt="" />
                    <h2>Tracking</h2>
                    <p class="muted">
                        The app tracks and saves you daily progress of your achvement
                    </p>
                </div>
                <div class="card flex flex-col">
                    <img src="./img/mynaui_save.png" alt="" />
                    <h2>Tracking</h2>
                    <p class="muted">
                        The app tracks and saves you daily progress of your achvement
                    </p>
                </div>
                <div class="card flex flex-col">
                    <img src="./img/ask.png" alt="" />
                    <h2>Tracking</h2>
                    <p class="muted">
                        The app tracks and saves you daily progress of your achvement
                    </p>
                </div>
            </div>
        </section>
        <section class="information flex flex-col between items-center">
            <div class="flex excellence">
                <div class="flex flex-col text">
                    <h1>Fit for Excellence</h1>
                    <p class="small muted">
                        Track your fitness journey with precision and style. Our app helps
                        you stay motivated, monitor progress, and achieve your goals
                        effortlessly.
                    </p>
                </div>
                <img src="./img/hand holding phone.png" alt="hand-holding-phone" />
            </div>
            <div class="flex items-center">
                <div class="flex flex-col text text-first">
                    <h1>Your Progress, Visualized</h1>
                    <p class="muted small">
                        Get detailed insights into your workouts with intuitive charts and
                        personalized recommendations. Watch your hard work translate into
                        real results.
                    </p>
                </div>
                <img src="./img/Black-Titanium.png" alt="2-phones" />
                <div class="flex flex-col text text-second">
                    <h1>Stay Connected, Stay Motivated</h1>
                    <p class="small muted">
                        Join a community of fitness enthusiasts. Share achievements, follow
                        friends, and celebrate progress together as you build your best self
                    </p>
                </div>
            </div>
        </section>
        <section class="about flex items-center" id="about">
            <div class="img">
                <img src="./img/man.png" alt="" />
            </div>
            <div class="content">
                <h1>About Us</h1>
                <p class="small muted">
                    We empower you to achieve your fitness goals with simple, effective
                    tools for tracking progress and staying motivated. Your journey, our
                    support.
                </p>
            </div>
        </section>
        <section class="get-started flex flex-col items-center">
            <h1>The best app for tracking and tanning together with professionals</h1>
            <p class="small muted">working sharing our achievement together</p>
            <a href="/get-started" class="btn">GET STARTED</a>
        </section>

        <footer class="flex between">
            <div class="flex flex-col">
                <a href class="logo flex items-center">
                    <img src="./img/logo.png" alt="logo-fit-forge" />
                    Fit forge
                </a>
                <p class="small muted">
                    Enabling workout at home with professionals and friends.
                </p>
                <div class="flex between">
                    <ul class="flex">
                        <li><a href="#">x</a></li>
                        <li><a href="#">In</a></li>
                        <li><a href="#">x</a></li>
                    </ul>
                </div>
            </div>
            <div class="flex">
                <ul>
                    <li>
                        <p class="bold">Link</p>
                    </li>
                    <li><a href="/#" class="small muted">Home</a></li>
                    <li><a href="/#info" class="small muted">Info</a></li>
                    <li><a href="/#about" class="small muted">About</a></li>
                    <li><a href="/get-started" class="small muted">Get Started</a></li>
                </ul>
            </div>
        </footer>

    @endauth
</body>

</html>