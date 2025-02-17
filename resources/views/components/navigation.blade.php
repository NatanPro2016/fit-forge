<div class="navgation flex between">
    <div class="user flex">
        <img src="{{ asset('./img/profile.png')}}" alt="user">
        <div>

            <h1> {{ $user->name}}</h1>
            <form action="/{{$page}}/logout" method="post">
                @csrf
                @method('DELETE')

                <button> <img src="{{ asset('./img/logout.png') }}" alt="logout"> logout</button>
        </div>
        </form>
    </div>
    <div class="time">
        <p>
            {{ $timestamp->format('H:i') }}
        </p>

    </div>

</div>