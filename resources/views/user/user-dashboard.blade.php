@extends('layouts.user')
@section('title', 'Dashboard')

@section('content')



<div class="dashboard content">
    <div class="progress">
        <div class="flex flex-col">

            <h1>
                Your progress
            </h1>
            <p class="muted">
                progress

            </p>
        </div>
    </div>
    <ul class="flex flex-col">
        <li> <a href="/users/create-plan" class="flex items-center"> <img src="{{ asset('/img/add.png')}}" alt="add">
                Create plan</a>
        </li>
        <li> <a href="/users/workouts" class="flex items-center"> <img src="{{ asset('/img/pin.png')}}" alt="add"
                    class="gray">
                discover workouts </a>
        </li>
        <li> <a href="/users/dicover-plans" class="flex items-center"> <img src="{{ asset('/img/pin.png')}}" alt="add"
                    class="gray">
                discover plans</a>
        </li>
        <li> <a href="/users/create-plan" class="flex items-center"> <img src="{{ asset('/img/pin.png')}}" alt="add"
                    class="gray">
                Create plan</a>
        </li>
        <li> <a href="/users/workouts" class="flex items-center"> <img src="{{ asset('/img/pin.png')}}" alt="add">
                workouts</a>
        </li>
        <li> <a href="/users/my-progress" class="flex items-center"> <img src="{{ asset('/img/pin.png')}}" alt="add">
                my progress</a>
        </li>

    </ul>
    @if (session('error'))
        {{session('error')}}
    @endif

</div>


@endsection




<!-- 



@if (session('success'))
    {{session('success')}}

@endif

@if (session('error'))
    {{session('error')}}

@endif


<h1> save plan </h1>




update user plan

<form action="/users/update-plan" method="post">
    @csrf
    <input type="number" placeholder="plan id" name='plan_id'>
    <input type="number" placeholder="worked dates" name='worked_dates'>
    <input type="number" placeholder="paued number" name='paued_number'>
    <input type="submit" value="submit">


</form>  -->