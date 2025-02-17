@extends('layouts.tranner')
@section('title', 'Dashboard')
@section('header')

<link rel="stylesheet" href="{{ asset('./css/form.css') }}">
@endsection



@section('content')


<div class="dashboard content ">
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
    <a href="/trainer/create-plan?id={{$id}}"> add more </a>
    <a href="/trainer/dashboard"> Finish</a>


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
      const response = await fetch(`/trainer/get-workout-plan?id=${id}&page=${page}`);
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

        container.setAttribute('href', `/trainer/workouts?id=${item.id}`)

        info.classList.add("info");
        heading.innerText = item.title;
        p.innerText = item.description;

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


  // Load more data on button click
  loadMoreButton.addEventListener("click", () => {
    const nextPage = loadMoreButton.dataset.page;
    fetchData(nextPage, currentSearchTerm); // Pass current search term to fetch
  });
</script>


@endsection