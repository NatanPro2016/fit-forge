@extends('layouts.tranner')
@section('title', 'Dashboard')

@section('content')
<div class="dashboard content">
    <div class="progress">
        <div class="flex flex-col">

            <h1>
                Your progress
            </h1>
            <p class="muted">


            </p>
        </div>
    </div>
    <ul class="flex flex-col">
        <li> <a href="/trainer/create-plan" class="flex items-center"> <img src="{{ asset('/img/add.png')}}" alt="add">
                Create plan</a>
        </li>
        <li> <a href="/trainer/workouts" class="flex items-center"> <img src="{{ asset('/img/pin.png')}}" alt="add"
                    class="gray">
                Discover workouts </a>
        </li>
        <li> <a href="/trainer/dicover-plans" class="flex items-center"> <img src="{{ asset('/img/pin.png')}}" alt="add"
                    class="gray">
                Discover plans</a>
        </li>
        <li> <a href="/trainer/create-workout" class="flex items-center"> <img src="{{ asset('/img/pin.png')}}"
                    alt="add" class="gray">
                Create workouts</a>
        </li>
        <li> <a href="/trainer/workouts" class="flex items-center"> <img src="{{ asset('/img/pin.png')}}" alt="add"
                    class="gray">
                Discover Workouts</a>
        </li>


    </ul>



</div>





@endsection