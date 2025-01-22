<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>

<body>
    <form action="{{route('file.upload')}}" method="post" enctype="multipart/form-data">
        @csrf
        @if ($message = Session::get('success'))
        created successfully
        @endif
        <input type="text" name="title" placeholder="title">
        @error('title')
            <div style="color: red;">{{ $message }}</div>
        @enderror
        <select name="target" id="">
            <option value="upper body"> upper body</option>
            <option value="lower body"> lower body</option>
            <option value="full body"> full body</option>

        </select>
        @error('target')
            <div style="color: red;">{{ $message }}</div>
        @enderror
        <input type="text" name="description" placeholder="description">
        @error('description')
            <div style="color: red;">{{ $message }}</div>
        @enderror
        <input type="file" name="image" accept="image/*" id="">
        @error('image')
            <div style="color: red;">{{ $message }}</div>
        @enderror
        <input type="text" name="video" placeholder="link">
        @error('video')
            <div style="color: red;">{{ $message }}</div>
        @enderror
        <input type="submit" value="create">

    </form>

</body>

</html>