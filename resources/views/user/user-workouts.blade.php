@extends('layouts.user')
@section('title', 'Dashboard')
@section('header')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>

    <link rel="stylesheet" href="{{ asset('./css/form.css') }}">
@endsection



@section('content')
    @if(request()->has('id'))
        @if ($data)

            <div class="content workouts">
                <h1>Discover Exercise</h1>
                <p class="muted">Workouts</p>
                <div class="workout-big">
                    <div class="header">
                        <img src="{{ asset('storage/' . $data->image) }}" alt="" class="profile">
                        <div class="information">
                            <h1> {{$data->title}}</h1>
                            <p class="muted"> {{$data->type}}</p>
                        </div>
                        <button id="save-button" onclick="saveWorkout({{$data->id}})">
                            <img src="{{ $data->is_saved == 1 ? asset('/img/saved.png') : asset('/img/save.png') }}" alt=""
                                id="saveicon">
                        </button>
                    </div>


                    <iframe width="560" height="315" src="{{$data->video}}" title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                    <p class="muted">
                        {{$data->description}}
                    </p>
                    <a href="/users/workouts" class="go-back"> <img src="{{asset('/img/back.png')}}" /> go back</a>

                </div>
            </div>

            <script>
                const saveIcon = document.getElementById("saveicon");


                const saveWorkout = async function (id) {
                    try {
                        const response = await fetch('/users/save-workout', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({ workout_id: id }),
                        });

                        response.json().then((result) => {
                            saveIcon.src = result.message.includes('removed') ? "{{asset('/img/save.png')}}" : "{{asset('/img/saved.png')}}";
                            Swal.fire({
                                title: 'Congratulations!',
                                text: result.message.includes('removed') ? "Successfully remove the workout!" : "Workout saved !",
                                icon: 'success',
                                confirmButtonText: 'Great!'
                            }).then((result) => {
                                console.log('finised');

                            })
                        })


                        // Update button text and state




                    } catch (error) {
                        console.error("Error saving workout:", error);
                    }
                }
            </script>
        @endif
    @else




        <div class="content workouts">

            <h1>Discover Exercise</h1>
            <p class="muted">Plan</p>

            <div class="search">
                <input type="text" id="search-input" placeholder="Search">
                <button id="search-button">
                    <img src="/img/search.png" alt="Search">
                </button>
            </div>
            <div class="input-group">
                <select id="filter">

                    <option value="">Filter</option>
                    <option value="saved">Saved</option>
                    <option value="type">By type</option>
                </select>
            </div>

            <!-- Loading Indicator -->


            <div id="workout-container"></div>
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
            const filter = document.getElementById("filter");

            let currentSearchTerm = ""; // Store the current search term

            async function fetchData(page = 1, search = "", type = false, saved = false) {
                try {
                    // Show loading indicator
                    loadingIndicator.style.display = "block";

                    const response = await fetch(`/users/get-workouts?page=${page}${type ? '&type=true' : ''}${saved ? '&saved=true' : ''}&search=${search}`);
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

                        container.setAttribute('href', `/users/workouts?id=${item.id}`)

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
            filter.addEventListener('change', (e) => {


                fetchData(1, currentSearchTerm, type = e.target.value === 'type', saved = e.target.value === 'saved'); // Fetch data with search term starting from page 1
                loadMoreButton.dataset.page = 2;




            })


            // Load more data on button click
            loadMoreButton.addEventListener("click", () => {
                const nextPage = loadMoreButton.dataset.page;
                fetchData(nextPage, currentSearchTerm); // Pass current search term to fetch
            });
        </script>
    @endif

@endsection