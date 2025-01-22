<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <div id="plan-container"></div>
    <button id="load-more-plan" data-page="1">Load More</button>

    <script>
        const loadMoreButton = document.getElementById("load-more-plan");
        const dataContainer = document.getElementById("plan-container");

        async function fetchData(page = 1) {
            try {
                const response = await fetch(`/trainer/get-plans?page=${page}`);
                const result = await response.json();

                // Append new data to the container
                result.data.forEach(item => {
                    const div = document.createElement("div");
                    div.innerText = item.id; // Adjust to your field name
                    dataContainer.appendChild(div);
                });

                // Check if more pages exist
                if (page >= result.last_page) {
                    loadMoreButton.style.display = "none"; // Hide the button
                } else {
                    loadMoreButton.dataset.page = parseInt(page) + 1; // Increment page
                }
            } catch (error) {
                console.error("Error fetching data:", error);
            }
        }

        // Load initial data
        fetchData();

        // Load more data on button click
        loadMoreButton.addEventListener("click", () => {
            const nextPage = loadMoreButton.dataset.page;
            fetchData(nextPage);
        });
    </script>



    <!-- Success Message -->
    @if(session('success'))
        <div style="background-color: green; color: white; padding: 10px;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Message -->
    @if(session('error'))
        <div style="background-color: red; color: white; padding: 10px;">
            {{ session('error') }}
        </div>
    @endif

    <form action="/trainer/create-workout-plan" method="post">
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


        <label for="plan_id">Plan ID</label>
        <input type="number" name="plan_id" required><br>
        @error('plan_id')<span>{{ $message }}</span>@enderror


        <label for="workout_id">Workout ID</label>
        <input type="number" name="workout_id" required><br>
        @error('workout_id')<span>{{ $message }}</span>@enderror

        <input type="submit" value="Create Plan">
    </form>

    <h2>Create Plan</h2>

    <!-- Display success message -->
    @if(session('success'))
        <div style="background-color: green; color: white; padding: 10px;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form for creating a new plan -->
    <form action="/trainer/create-plan" method="POST">
        @csrf
        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required>
            @error('title')<span>{{ $message }}</span>@enderror
        </div>
        <div>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required>{{ old('description') }}</textarea>
            @error('description')<span>{{ $message }}</span>@enderror
        </div>
        <div>
            <label for="duration">Duration:</label>
            <input type="number" id="duration" name="duration" value="{{ old('duration') }}" required>
            @error('duration')<span>{{ $message }}</span>@enderror
        </div>
        <div>
            <label for="type">Type:</label>
            <input type="text" id="type" name="type" value="{{ old('type') }}" required>
            @error('type')<span>{{ $message }}</span>@enderror
        </div>
        <div>
            <label for="count">Count:</label>
            <input type="number" id="count" name="count" value="{{ old('count') }}" required>
            @error('count')<span>{{ $message }}</span>@enderror
        </div>


        <button type="submit">Create Plan</button>
    </form>

    <div id="workout-container"></div>
    <button id="load-more-workout" data-page="1">Load More</button>

    <script>
        const loadMoreWorkoutButton = document.getElementById("load-more-workout");
        const workoutContainer = document.getElementById("workout-container");

        async function fetchWorkouts(page = 1) {
            try {
                const response = await fetch(`/trainer/get-workouts?page=${page}`);
                const result = await response.json();

                // Append new data to the container
                result.data.forEach(item => {
                    const divWorkout = document.createElement("div");
                    divWorkout.innerText = item.id; // Adjust to your field name
                    workoutContainer.appendChild(divWorkout);
                });

                // Check if more pages exist
                if (page >= result.last_page) {
                    loadMoreWorkoutButton.style.display = "none"; // Hide the button
                } else {
                    loadMoreWorkoutButton.dataset.page = parseInt(page) + 1; // Increment page
                }
            } catch (error) {
                console.error("Error fetching data:", error);
            }
        }

        // Load initial data
        fetchWorkouts();

        // Load more data on button click
        loadMoreWorkoutButton.addEventListener("click", () => {
            const nextPageWorkout = loadMoreWorkoutButton.dataset.page;
            fetchWorkouts(nextPageWorkout);
        });
    </script>

</body>

</html>