@extends('layouts.tranner')
@section('title', 'Dashboard')
@section('header')

<link rel="stylesheet" href="{{ asset('./css/form.css') }}">
@endsection
@section('content')
<div class="dashboard content flex flex-col">
    <h1 class="small">Create Yourown Plan</h1>
    <p class="muted">Workouts</p>


    <form action="{{route('file.upload')}}" method="post" enctype="multipart/form-data" >
        @csrf
        @if ($message = Session::get('success'))
            created successfully
        @endif
        <div class="input-group">
            <label for="title"> Title</label>
            <input type="text" name="title" placeholder="title" id="title">
            @error('title')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <div class="input-group">
            <label for="target">Target</label>
            <select name="target" id="target">
                <option value="upper body"> upper body</option>
                <option value="lower body"> lower body</option>
                <option value="full body"> full body</option>

            </select>
            @error('target')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>
        <div class="input-group">
            <label for="description">Target</label>
            <input type="text" name="description" placeholder="description" id="description">
            @error('description')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>
        <div class="input-group">
            <label for="image">Image</label>
            <input type="file" name="image" accept="image/*" id="image">
            @error('image')
                <div style="color: red;">{{ $message }}</div>
            @enderror

        </div>
        <div class="input-group">
            <label for="video" class="flex">Video <p class="muted"> (youtube link)</p></label>
            <input type="text" name="video" placeholder="link" id="video">
            @error('video')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <input type="submit" value="create">

    </form>
</div>
@endsection