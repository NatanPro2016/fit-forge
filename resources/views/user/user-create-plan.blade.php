@extends('layouts.user')
@section('title', 'Dashboard')
@section('header')

    <link rel="stylesheet" href="{{ asset('./css/form.css') }}">
@endsection



@section('content')



    <div class="dashboard content flex flex-col">
        <h1 class="small">Create Yourown Plan</h1>
        <p class="muted">Workouts</p>


        <div class="form-container">
            @if (!request('id') && !session('success'))

                <div class="center">
                    <form action="/users/create-plan" method="POST" class="create-plan">
                        @if(session('success'))
                            <div style="background-color: green; color: white; padding: 10px;">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div style="background-color: red; color: white; padding: 10px;">
                                {{ session('error') }}
                            </div>
                        @endif
                        @csrf
                        <div class="input-group">
                            <label for="title">Title</label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" placeholder="Title" required>
                            @error('title')<span>{{ $message }}</span>@enderror
                        </div>
                        <div class="input-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" required
                                placeholder="Description">{{ old('description') }} </textarea>
                                @error('title')<span>{{ $message }}</span>@enderror
                        </div>
                        <div class="input-group">
                            <label for="duration">Duration</label>
                            <input type="number" id="duration" name="duration" value="{{ old('duration') }}"
                                placeholder="Duration" required>
                            @error('duration')<span>{{ $message }}</span>@enderror
                        </div>
                        <div class="input-group">
                            <label for="type">Type</label>
                            <input type="text" id="type" name="type" value="{{ old('type') }}" required placeholder="Type">
                            @error('type')<span>{{ $message }}</span>@enderror
                        </div>
                        <button type="submit" class="create-plan">Create Plan</in>
                    </form>
                </div>
            @else

                <div class="plan-workout">
                    <div class="search">
                        <input type="text" id="search-input" placeholder="Search">
                        <button id="search-button">
                            <img src="/img/search.png" alt="Search">
                        </button>
                    </div>

                    <div id="workout-container" class="create-plan">

                    </div>
                    <div id="loading" style="display: none; text-align: center; margin: 20px;">
                        <div class="spinner"></div>
                        <p>Loading...</p>
                    </div>
                    <button id="load-more-workout" class="load-more" data-page="1" style="display: none;">Load More</button>

                </div>



                <script defer>
                    const loadMoreButton = document.getElementById("load-more-workout");
                    const dataContainer = document.getElementById("workout-container");
                    const searchInput = document.getElementById("search-input");
                    const searchButton = document.getElementById("search-button");
                    const loadingIndicator = document.getElementById("loading");

                    let currentSearchTerm = ""; // Store the current search term

                    async function fetchData(page = 1, search = "") {
                        try {
                            // Show loading indicator
                            loadingIndicator.style.display = "block";

                            const response = await fetch(`/users/get-workouts?page=${page}&search=${search}`);
                            const result = await response.json();

                            // Clear container if it's a new search
                            if (page === 1) {
                                dataContainer.innerHTML = ""; // Clear previous data
                            }

                            // Append new data to the container
                            result.data.forEach(item => {
                                const container = document.createElement("a");
                                const info = document.createElement("div");
                                const img = document.createElement("img");
                                const heading = document.createElement("h1");
                                const p = document.createElement("p");


                                let plan_id = @json(session('plan_id')) || @json(request('id'))

                                container.setAttribute('href', `/users/create-workout-plan?id=${item.id}&plan_id=${plan_id}`)

                                info.classList.add("info");
                                heading.innerText = item.title;
                                p.innerText = `${item.description.substring(0, 30)} ${item.description.length >= 30 ? '...' : ''}`;

                                img.src = `/storage/${item.image}`;
                                img.alt = "Workout Image";

                                info.appendChild(heading);
                                info.appendChild(p);

                                container.appendChild(img);
                                container.appendChild(info);
                                container.classList.add("workout");

                                dataContainer.appendChild(container);
                            });

                            // Check if more pages exist
                            if (page >= result.last_page) {
                                loadMoreButton.style.display = "none"; // Hide the button
                            } else {
                                loadMoreButton.style.display = "block"; // Show the button
                                loadMoreButton.dataset.page = parseInt(page) + 1; // Increment page
                            }
                        } catch (error) {
                            console.error("Error fetching data:", error);
                        } finally {
                            // Hide loading indicator
                            loadingIndicator.style.display = "none";
                        }
                    }

                    // Load initial data
                    fetchData();

                    // Search functionality
                    searchButton.addEventListener("click", () => {
                        currentSearchTerm = searchInput.value.trim();
                        fetchData(1, currentSearchTerm); // Fetch data with search term starting from page 1
                        loadMoreButton.dataset.page = 2; // Reset pagination
                    });

                    // Trigger search when pressing Enter in the search input
                    searchInput.addEventListener("keyup", (event) => {

                        currentSearchTerm = searchInput.value.trim();
                        fetchData(1, currentSearchTerm); // Fetch data with search term starting from page 1
                        loadMoreButton.dataset.page = 2; // Reset pagination

                    });

                    // Load more data on button click
                    loadMoreButton.addEventListener("click", () => {
                        const nextPage = loadMoreButton.dataset.page;
                        fetchData(nextPage, currentSearchTerm); // Pass current search term to fetch
                    });
                </script>




            @endif


        </div>


        <div class="indecator">
            <div class="circle active">
            </div>
            <div class="line active"></div>
            <div class="circle {{  (request('id') || session('success')) ? 'active' : '' }}">
            </div>
            <div class="line {{  (request('id') || session('success')) ? 'active' : '' }}"></div>
            <div class="circle">
            </div>

        </div>

    </div>






@endsection


















<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>create plan</title>
</head>

<body>

   

    <form action="/users/create-workout-plan" method="post">
        @csrf

        <label for="duration">Duration</label>
        <input type="number" name="duration" required><br>
        @error('duration')<span>{{ $message }}</span>@enderror


        <label for="incrimination">Incrimination</label>
        <input type="number" name="incrimination" required><br>

        <label for="mon">Monday</label>
        <input type="checkbox" name="mon"><br>

        <label for="tues">Tuesday</label>
        <input type="checkbox" name="tues"><br>

        <label for="wed">Wednesday</label>
        <input type="checkbox" name="wed"><br>

        <label for="thurs">Thursday</label>
        <input type="checkbox" name="thurs"><br>


        <label for="fri">Friday</label>
        <input type="checkbox" name="fri"><br>
        @error('fri')<span>{{ $message }}</span>@enderror


        <label for="sat">Saturday</label>
        <input type="checkbox" name="sat"><br>
        @error('sat')<span>{{ $message }}</span>@enderror


        <label for="sun">Sunday</label>
        <input type="checkbox" name="sun"><br>
        @error('sun')<span>{{ $message }}</span>@enderror


        <label for="custom_plan_id">Plan ID</label>
        <input type="number" name="custom_plan_id" required><br>
        @error('custom_plan_id')<span>{{ $message }}</span>@enderror


        <label for="workout_id">Workout ID</label>
        <input type="number" name="workout_id" required><br>
        @error('workout_id')<span>{{ $message }}</span>@enderror

        <input type="submit" value="Create Plan">
    </form>


</body>

</html> -->