@extends('layouts.tranner')
@section('title', 'Dashboard')

@section('content')

@if (request()->has('id'))
    <div class="dashboard content">
        <h1> Exercise of the plan </h1>
        <p class="muted">workouts</p>

        <!-- Loading Indicator -->


        <div id="plan-container"></div>
        <div id="loading" style="display: none; text-align: center; margin: 20px;">
            <div class="spinner"></div>
            <p>Loading...</p>
        </div>
        <button id="load-more-plan" class="load-more" data-page="1" style="display: none;">Load More</button>



    </div>

    <script defer>
        const loadMoreButton = document.getElementById("load-more-plan");
        const dataContainer = document.getElementById("plan-container");
        const loadingIndicator = document.getElementById("loading");

        let currentSearchTerm = ""; // Store the current search term

        async function fetchData(page = 1, search = "") {
            try {
                // Show loading indicator
                loadingIndicator.style.display = "block";
                let id = @json(request('id'))

                const response = await fetch(`/trainer/get-dicover-plans?id=${id}&page=${page}`);
                const result = await response.json();

                // Clear container if it's a new search
                if (page === 1) {
                    dataContainer.innerHTML = ""; // Clear previous data
                }

                // Append new data to the container
                result.data.forEach((item, i) => {
                    const container = document.createElement("div");
                    if (i === 0) {
                        // create plan heading the top 
                        const info = document.createElement("div");
                        const heading = document.createElement("h1");
                        const p = document.createElement("p");
                        info.classList.add("info");
                        heading.innerText = item.title;
                        p.innerText = item.description;
                        info.appendChild(heading);
                        info.appendChild(p);
                        container.appendChild(info);
                    }

                    const workoutTop = document.createElement('div');
                    const workoutInfo = document.createElement('div');

                    const img = document.createElement('img')
                    const workoutTitle = document.createElement('h1');
                    const type = document.createElement('p');
                    const video = document.createElement('iframe');
                    const workoutDescription = document.createElement('p');


                    workoutInfo.classList.add('workout-info');


                    img.src = `/storage/${item.image}`;
                    workoutTitle.innerText = item.workout_title;
                    type.innerText = item.workout_type;


                    workoutInfo.appendChild(workoutTitle);
                    workoutInfo.appendChild(type);
                    workoutTop.classList.add('workout-top')
                    workoutTop.appendChild(img);
                    workoutTop.appendChild(workoutInfo);



                    video.src = item.video
                    video.width = '600';
                    video.height = '190';

                    workoutDescription.innerText = item.workout_description
                    container.appendChild(workoutTop)
                    container.appendChild(video);
                    container.appendChild(workoutDescription)

                    container.classList.add("plan");
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





        // Load more data on button click
        loadMoreButton.addEventListener("click", () => {
            const nextPage = loadMoreButton.dataset.page;
            fetchData(nextPage, currentSearchTerm); // Pass current search term to fetch
        });
    </script>



@else
    <div class="dashboard content">
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


        <div id="plan-container"></div>
        <div id="loading" style="display: none; text-align: center; margin: 20px;">
            <div class="spinner"></div>
            <p>Loading...</p>
        </div>
        <button id="load-more-plan" class="load-more" data-page="1" style="display: none;">Load More</button>
        <a href="/users/create-plan">add plan</a>



    </div>

    <script defer>
        const loadMoreButton = document.getElementById("load-more-plan");
        const dataContainer = document.getElementById("plan-container");
        const searchInput = document.getElementById("search-input");
        const searchButton = document.getElementById("search-button");
        const loadingIndicator = document.getElementById("loading");

        let currentSearchTerm = ""; // Store the current search term

        async function fetchData(page = 1, search = "") {
            try {
                // Show loading indicator
                loadingIndicator.style.display = "block";

                const response = await fetch(`/trainer/get-dicover-plans?page=${page}&search=${search}`);
                const result = await response.json();

                // Clear container if it's a new search
                if (page === 1) {
                    dataContainer.innerHTML = ""; // Clear previous data
                }

                // Append new data to the container
                result.data.forEach(item => {
                    const container = document.createElement("a");
                    const info = document.createElement("div");

                    const heading = document.createElement("h1");
                    const p = document.createElement("p");

                    container.setAttribute('href', `/trainer/dicover-plans?id=${item.id}`)

                    info.classList.add("info");
                    heading.innerText = item.title;
                    p.innerText = item.description;


                    info.appendChild(heading);
                    info.appendChild(p);


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


@endsection