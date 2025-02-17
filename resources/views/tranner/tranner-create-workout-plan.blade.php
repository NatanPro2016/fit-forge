@extends('layouts.tranner')
@section('title', 'Dashboard')
@section('header')

<link rel="stylesheet" href="{{ asset('./css/form.css') }}">
@endsection



@section('content')
@if(request()->has('id'))

    <div class="dashboard content flex flex-col">
        @php
            $id = request('id');
            $plan_id = request('plan_id');
        @endphp


        <h1 class="small">Create Your own Plan</h1>
        <p class="muted">Workouts</p>
        <div id="loading" style="display: none; text-align: center; margin: 20px;">
            <div class="spinner"></div>
            <p>Loading...</p>
        </div>

        <div id="workout-container">

        </div>
        <form action="/trainer/create-workout-plan" method="post">
            @csrf

            <label for="duration">Duration</label>
            <input type="number" name="duration" required><br>
            @error('duration')<span>{{ $message }}</span>@enderror


            <label for="incrimination">Incrimination</label>
            <input type="number" name="incrimination" required><br>

            <label for="Mon">Monday</label>
            <input type="checkbox" name="Mon"><br>

            <label for="Tues">Tuesday</label>
            <input type="checkbox" name="Tues"><br>

            <label for="Wed">Wednesday</label>
            <input type="checkbox" name="Wed"><br>

            <label for="Thurs">Thursday</label>
            <input type="checkbox" name="Thurs"><br>


            <label for="Fri">Friday</label>
            <input type="checkbox" name="Fri"><br>
            @error('Fri')<span>{{ $message }}</span>@enderror


            <label for="Sat">Saturday</label>
            <input type="checkbox" name="Sat"><br>
            @error('Sat')<span>{{ $message }}</span>@enderror


            <label for="Sun">Sunday</label>
            <input type="checkbox" name="Sun"><br>
            @error('Sun')<span>{{ $message }}</span>@enderror



            <input type="hidden" name="plan_id" required value="{{$plan_id}}"><br>
            @error('plan_id')<span>{{ $message }}</span>@enderror



            <input type="hidden" value="{{$id}}" name="workout_id" required><br>
            @error('workout_id')<span>{{ $message }}</span>@enderror

            <input type="submit" value="Create Plan">
        </form>


        <div class="indecator">
            <div class="circle active">
            </div>
            <div class="line active"></div>
            <div class="circle active">
            </div>
            <div class="line active"></div>
            <div class="circle">
            </div>

        </div>
    </div>


    <script defer>

        const dataContainer = document.getElementById("workout-container");
        const loadingIndicator = document.getElementById("loading");



        async function fetchData() {
            try {
                // Show loading indicator
                loadingIndicator.style.display = "block";
                let id = {{$id}};

                const response = await fetch(`/trainer/get-workouts?id=${id}`);
                const result = await response.json();

                // Clear container if it's a new search


                // Append new data to the container




                const container = document.createElement("div");
                const info = document.createElement("div");
                const img = document.createElement("img");
                const heading = document.createElement("h1");
                const p = document.createElement("p");



                info.classList.add("info");
                heading.innerText = result[0].title;
                p.innerText = result[0].description;

                img.src = `/storage/${result[0].image}`;
                img.alt = "Workout Image";

                info.appendChild(heading);
                info.appendChild(p);

                container.appendChild(img);
                container.appendChild(info);
                container.classList.add("workout");

                dataContainer.appendChild(container);




            } catch (error) {
                console.error("Error fetching data:", error);
            } finally {
                // Hide loading indicator
                loadingIndicator.style.display = "none";
            }
        }

        // Load initial data
        fetchData();
    </script>


@endif




@endsection