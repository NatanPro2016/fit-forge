@extends('layouts.user')
@section('title', 'Dashboard')
@section('header')
  <link rel="stylesheet" href="{{ asset('./css/show-workout.css') }}">

@endsection



@section('content')


  <div class="dashboard content show-workout">
    @if(request()->has('id'))
    @php
    $id = request('id');
  @endphp
    <h1 class="small"> show workout plan</h1>
    <p class="mute"> workout</p>

    <div id="container">

    </div>
    <div id="loading" style="display: none; text-align: center; margin: 20px;">
    <div class="spinner"></div>
    <p>Loading...</p>
    </div>
    <button id="load-more" class="load-more" data-page="1" style="display: none;">Load More</button>
    <a href="/users/create-plan?id={{$id}}" class="add-more"> Add more </a>
    <a href="/users/dashboard" class="finish"> Finish</a>


  @endif
  </div>

  <script defer>
    const loadMoreButton = document.getElementById("load-more");
    const dataContainer = document.getElementById("container");

    const loadingIndicator = document.getElementById("loading");

    // Store the current search term

    async function fetchData(page = 1,) {
    try {
      // Show loading indicator
      loadingIndicator.style.display = "block";
      let id = @json($id);
      const response = await fetch(`/users/get-workout-plan?id=${id}&page=${page}`);
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
      const count = document.createElement("p")

      container.setAttribute('href', `/users/workouts?id=${item.id}`)

      info.classList.add("info");
      heading.innerText = item.title;
      p.innerText = item.description;
      count.innerText = item.duration + 'X';

      img.src = `/storage/${item.image}`;
      img.alt = "Workout Image";

      info.appendChild(heading);
      info.appendChild(p);

      const data = {
        "Mon": item.Mon,
        "Tues": item.Tues,
        "Wed": item.Wed,
        "Thurs": item.Thurs,
        "Fri": item.Fri,
        "Sat": item.Sat,
        "Sun": item.Sun
      };
      const circleContainer = document.createElement('div')
      circleContainer.classList.add('circle-container')
      for (const [day, value] of Object.entries(data)) {
        const circle = document.createElement('div');
        circle.innerText = day[0]
        circle.classList.add('circle');
        if (value === 1) {
        circle.classList.add('active');
        }
        circleContainer.appendChild(circle);
      }


      const aligner = document.createElement('div');
      aligner.classList.add("aligner");
      aligner.appendChild(img);
      aligner.appendChild(info)
      aligner.appendChild(count)

      container.appendChild(aligner);
      container.appendChild(circleContainer)
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


    // Load more data on button click
    loadMoreButton.addEventListener("click", () => {
    const nextPage = loadMoreButton.dataset.page;
    fetchData(nextPage); // Pass current search term to fetch
    });
  </script>


@endsection