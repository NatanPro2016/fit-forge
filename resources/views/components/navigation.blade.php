<div class="card">

    {{ $user->id }}

    <form action="/trainer/logout" method="post">
        @csrf
        @method('DELETE')

        <input type="submit" value="logout">
    </form>

</div>