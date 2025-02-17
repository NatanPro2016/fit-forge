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
        $page = 'trainer';
        
        @endphp

        <x-navigation :user="Auth::guard('tanner')->user()" :page="$page" ></x-navigation>
        <div class="col"> 
          
                @yield('content')        
         
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