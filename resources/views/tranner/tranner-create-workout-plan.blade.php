@extends('layouts.tranner')
@section('title', 'Dashboard')
@section('header')


    <link rel="stylesheet" href="{{ asset('./css/form.css') }}">
@endsection



@section('content')
    @if(request()->has('id'))

        <div class="dashboard content flex flex-col create-workout-plan ">
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
                <div class="days">
                    <input type="checkbox" name="Mon" id="Mon">
                    <label for="Mon">M</label>

                    <input type="checkbox" name="Tues" id="Tues">
                    <label for="Tues">T</label>

                    <input type="checkbox" name="Wed" id="Wed">
                    <label for="Wed">W</label>

                    <input type="checkbox" name="Thurs" id="Thurs">
                    <label for="Thurs">T</label>

                    <input type="checkbox" name="Fri" id="Fri">
                    <label for="Fri">F</label>

                    <input type="checkbox" name="Sat" id="Sat">
                    <label for="Sat">S</label>

                    <input type="checkbox" name="Sun" id="Sun">
                    <label for="Sun">S</label>

                </div>
                <label for="duration" class="muted numbers"> Duration</label>
                <div class="number-input">

                    <div id="decrement-duration">-</div>
                    <input type="number" id="duration" name="duration" value="0" min="0" max="100">
                    <div id="increment-duration">+</div>

                    @error('duration')<span>{{ $message }}</span>@enderror
                </div>

                <label for="incrimination" class="muted numbers">Incrimination</label>
                <div class="number-input">
                    <div id="decrement-incrimination">-</div>
                    <input type="number" name="incrimination" id="incrimination" value="0" min="0" max="100" required>
                    <div id="increment-incrimination">+</div>

                </div>



                <input type="hidden" name="plan_id" required value="{{$plan_id}}"><br>


                <input type="hidden" value="{{$id}}" name="workout_id" required><br>


                <input type="submit" value="Create Plan" class="btn">
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
        <script defer>


            // Get references to the input and buttons
            const inputDuration = document.getElementById('duration');
            const incrementButton = document.getElementById('increment-duration');
            const decrementButton = document.getElementById('decrement-duration');

            // Increment the value when the "+" button is clicked
            incrementButton.addEventListener('click', () => {
                inputDuration.stepUp(); // Increases the value by 1
            });

            // Decrement the value when the "-" button is clicked
            decrementButton.addEventListener('click', () => {
                inputDuration.stepDown(); // Decreases the value by 1
            });


            // the second slider 
            const inputIncrimination = document.getElementById('incrimination');
            const incrementButtonIncrimination = document.getElementById('increment-incrimination');
            const decrementButtonIncrimination = document.getElementById('decrement-incrimination');

            // Increment the value when the "+" button is clicked
            incrementButtonIncrimination.addEventListener('click', () => {
                inputIncrimination.stepUp(); // Increases the value by 1
            });

            // Decrement the value when the "-" button is clicked
            decrementButtonIncrimination.addEventListener('click', () => {
                inputIncrimination.stepDown(); // Decreases the value by 1
            });
        </script>


    @endif




@endsection