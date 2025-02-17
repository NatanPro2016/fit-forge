@extends('layouts.user')
@section('title', 'Dashboard')
@section('header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>

    <link rel="stylesheet" href="{{ asset('./css/form.css') }}">
@endsection



@section('content')


    @if (request()->has('id'))

        <div class="dashboard content">
            <h1> Your progress </h1>
            <p class="muted">progress</p>

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

                    const response = await fetch(`/users/get-my-progress?id=${id}&page=${page}`);
                    const result = await response.json();

                    // Clear container if it's a new search
                    if (page === 1) {
                        dataContainer.innerHTML = ""; // Clear previous data
                    }


                    let noWorkoutsToday = true;
                    let user_plan_id = null;
                    let worked_dates = null;
                    let doneButtonShowed = false;
                    let local_paued_number = result.data[0].paued_number;
                    // creating header for plan information 
                    const info = document.createElement("div");
                    const heading = document.createElement("h1");
                    const p = document.createElement("p");
                    info.classList.add("info");
                    heading.innerText = result.data[0].plan_title;
                    p.innerText = result.data[0].plan_description;
                    info.appendChild(heading);
                    info.appendChild(p);
                    dataContainer.appendChild(info);
                    user_plan_id = result.data[0].u_p_user_plans_id;
                    worked_dates = result.data[0].worked_dates;


                    // Append new data to the container
                    result.data.forEach((item, i) => {
                        const container = document.createElement("div");
                        container.id = item.row_index

                        next_id = i >= result.data.length >= i ? result.data[i + 1].row_index : item.row_index;

                        const pausedDate = Number(item.workout_count);

                        const dates = ['Mon', 'Tues', 'Wed', 'Thurs', 'Fri', 'Sat', 'Sun'];

                        const dateIndex = item.worked_dates % 7 === 0 ? 7 : item.worked_dates % 7;

                        if (!item[dates[dateIndex - 1]]) {
                            local_paued_number++
                        }

                        else {

                            noWorkoutsToday = false
                            const workoutTop = document.createElement('div');
                            const workoutInfo = document.createElement('div');

                            const img = document.createElement('img')
                            const workoutTitle = document.createElement('h1');
                            const type = document.createElement('p');
                            const video = document.createElement('iframe');
                            const descriptionContaner = document.createElement('div');
                            const workoutDescription = document.createElement('p');
                            const duration = document.createElement('p')


                            workoutInfo.classList.add('workout-info');
                            descriptionContaner.classList.add('description-contaner')

                            img.src = `/storage/${item.image}`;
                            workoutTitle.innerText = item.workout_title;
                            type.innerText = item.workout_type;


                            workoutInfo.appendChild(workoutTitle);
                            workoutInfo.appendChild(type);
                            workoutTop.classList.add('workout-top')
                            workoutTop.appendChild(img);
                            workoutTop.appendChild(workoutInfo);

                            const done = document.createElement('button');
                            done.innerText = 'done';


                            done.addEventListener('click', async () => {
                                try {
                                    if (page >= result.last_page && i + 1 == result.data.length) {
                                        const response = await fetch('/users/update-progress', {
                                            method: 'POST',
                                            headers: { "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"), },
                                            body: JSON.stringify({
                                                paued_number: null,
                                                user_plan_id: item.u_p_user_plans_id,
                                                worked_dates: item.worked_dates ? item.worked_dates + 1 : 1
                                            })

                                        },)
                                        response.json().then(() => {

                                            console.log("Success:", result);
                                            Swal.fire({
                                                title: 'Congratulations!',
                                                text: 'You have completed today\'s workout!',
                                                icon: 'success',
                                                confirmButtonText: 'Great!'
                                            }).then((result) => {

                                                if (result.isConfirmed) {
                                                    // Redirect to the dashboard
                                                    window.location.href = '/users/dashboard';
                                                }
                                            })

                                            console.log("Success:", result);
                                        })

                                    }

                                    else {

                                        const response = await fetch('/users/update-progress', {
                                            method: 'POST',
                                            headers: { "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"), },
                                            body: JSON.stringify({ paued_number: item.row_index, user_plan_id: item.u_p_user_plans_id, worked_dates: null })

                                        },)
                                        response.json().then((result) => {
                                            console.log(result)
                                        })
                                    }
                                    container.style.opacity = 0.3;
                                    done.style.display = 'none';
                                    // document.getElementById(next_id).queryquerySelector('button').style.display = "block";
                                    const next_id = i + 1 >= result.data.length ? item.row_index : result.data[i + 1].row_index;


                                    document.getElementById(next_id).querySelector('button').style.display = 'block';
                                    local_paued_number++

                                }
                                catch (e) {
                                    console.log(e);
                                }

                            })
                            workoutTop.appendChild(done);






                            if (item.row_index <= local_paued_number) {
                                container.style.opacity = 0.3
                                done.style.display = 'none'
                            }


                            else if (item.row_index > local_paued_number + 1) {
                                done.style.display = 'none';
                            }




                            video.src = item.video
                            video.width = '600';
                            video.height = '190';

                            duration.innerText = item.duration + item.incrimination * Math.floor(worked_dates / 7) + 'X'
                            workoutDescription.innerText = item.workout_description



                            descriptionContaner.appendChild(workoutDescription)
                            descriptionContaner.appendChild(duration)
                            container.appendChild(workoutTop)
                            container.appendChild(video);
                            container.appendChild(descriptionContaner)

                            container.classList.add("plan");
                            dataContainer.appendChild(container);
                        }



                    });
                    if (noWorkoutsToday) {
                        const noWorkoutsToday = document.createElement("p");
                        noWorkoutsToday.innerText = 'No Workout today go rest'
                        dataContainer.appendChild(noWorkoutsToday)
                        const goNext = document.createElement('button');
                        goNext.innerText = 'Finish resting'
                        goNext.addEventListener('click', async () => {


                            const response = await fetch('/users/update-progress', {
                                method: 'POST',
                                headers: { "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"), },
                                body: JSON.stringify({
                                    paued_number: null,
                                    user_plan_id,
                                    worked_dates: worked_dates + 1,
                                })

                            },)
                            await response.json().then((result) => {

                                console.log("Success:", result);
                                location.reload()
                            })


                        });
                        dataContainer.appendChild(goNext)

                    }


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
            <h1> My progress </h1>
            <p class="muted">progress</p>



            <!-- Loading Indicator -->


            <div id="plan-container"></div>
            <div id="loading" style="display: none; text-align: center; margin: 20px;">
                <div class="spinner"></div>
                <p>Loading...</p>
            </div>
            <button id="load-more-plan" class="load-more" data-page="1" style="display: none;">Load More</button>
            <a href="/users/create-plan"></a>



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

                    const response = await fetch(`/users/get-my-progress?page=${page}`);
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


                        container.setAttribute('href', `/users/my-progress?id=${item.user_plan_id}`)

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