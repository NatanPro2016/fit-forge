<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>    
    <link rel="stylesheet" href="{{ asset('./css/dashboard.css') }}">
    @yield('header')

    <link rel="icon" href="{{ asset('./img/logo.png') }}">
</head>

<body>
    <section >
        @php
        $page = 'users';
        
        @endphp

        <x-navigation :user="Auth::user()" :page="$page" ></x-navigation>
        <div class="col"> 
            <div class="flex flex-col content-holder">
                <div class="menu">
                    <ul class="flex">
                        <li><a href="/users/dashboard"><img src="{{ asset('./img/home.png') }}" alt="home"> </a></li>
                         <li><a href="/users/dicover-plans"><img src="{{ asset('./img/solar_running-bold-black.png') }}" alt="home"> </a></li>
                        <li><a href="/users/my-progress"><img src="{{ asset('./img/progress.png') }}" alt="my-progress"></a></li>
                    </ul>
                </div>

                @yield('content')        
            </div>
          
         
            <div class="image">
                <img src="{{ asset('./img/trainer.png') }}" alt="">
            </div>
            <div class="graph">
                <div class="first">
                    
                </div>
                <div class="first">
                    
                    </div>

            </div>

        </div>
    
    </section>


</body>

</html>