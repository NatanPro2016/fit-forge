@extends('layouts.tranner')
@section('title', 'Dashboard')
@section('header')


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
                <a href="/trainer/workouts" class="go-back"> <img src="{{asset('/img/back.png')}}" /> go back</a>

            </div>
        </div>

        <script>
            const saveIcon = document.getElementById("saveicon");


            const saveWorkout = async function (id) {
                try {
                    const response = await fetch('/trainer/save-workout', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({ workout_id: id }),
                    });

                    const result = await response.json();
                    alert(result.message);

                    // Update button text and state

                    saveIcon.src = result.message.includes('removed') ? "{{asset('/img/save.png')}}" : "{{asset('/img/saved.png')}}"


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

        let currentSearchTerm = ""; // Store the current search term

        // Function to get URL parameters
        function getQueryParam(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        // Function to update URL parameters
        function updateURLParam(param, value) {
            const url = new URL(window.location);
            url.searchParams.set(param, value);
            window.history.pushState({}, "", url); // Update the URL without reloading
        }

        async function fetchData(page = 1, search = "") {
            try {
                loadingIndicator.style.display = "block";

                const response = await fetch(`/trainer/get-workouts?page=${page}&search=${search}`);
                const result = await response.json();

                if (page === 1) {
                    dataContainer.innerHTML = ""; // Clear previous data
                }

                result.data.forEach(item => {
                    const container = document.createElement("a");
                    const info = document.createElement("div");
                    const img = document.createElement("img");
                    const heading = document.createElement("h1");
                    const p = document.createElement("p");

                    container.setAttribute('href', `/trainer/workouts?id=${item.id}`);

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

                if (page >= result.last_page) {
                    loadMoreButton.style.display = "none"; // Hide the button
                } else {
                    loadMoreButton.style.display = "block"; // Show the button
                    loadMoreButton.dataset.page = parseInt(page) + 1; // Increment page
                }

                updateURLParam("page", page); // Update the page in the URL
            } catch (error) {
                console.error("Error fetching data:", error);
            } finally {
                loadingIndicator.style.display = "none";
            }
        }

        // Get initial page from URL or default to 1
        const initialPage = getQueryParam("page") || 1;
        fetchData(initialPage);

        // Search functionality
        searchButton.addEventListener("click", () => {
            currentSearchTerm = searchInput.value.trim();
            fetchData(1, currentSearchTerm); // Fetch from page 1
            loadMoreButton.dataset.page = 2; // Reset pagination
            updateURLParam("search", currentSearchTerm); // Update search in URL
        });

        // Search on Enter key
        searchInput.addEventListener("keyup", (event) => {
            if (event.key === "Enter") {
                currentSearchTerm = searchInput.value.trim();
                fetchData(1, currentSearchTerm);
                loadMoreButton.dataset.page = 2;
                updateURLParam("search", currentSearchTerm);
            }
        });

        // Load more button
        loadMoreButton.addEventListener("click", () => {
            const nextPage = loadMoreButton.dataset.page;
            fetchData(nextPage, currentSearchTerm);
        });

    </script>
@endif

@endsection