<h1>Create Album</h1>

<form action="{{ route('admin.albums.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div>
        <label>Group:</label>
        <select name="group_id">
            @foreach($groups as $group)
                <option value="{{ $group->id }}">{{ $group->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Album Name:</label>
        <input type="text" name="name">
    </div>

    <div>
        <label>Release Date:</label>
        <input type="date" name="release_date">
    </div>

    <div>
        <label>Track Count:</label>
        <input type="number" name="track_count" min="0">
    </div>

    <div>
        <label>Album Cover Image:</label>
        <input type="file" name="image">
    </div>

    <button type="submit">Create Album</button>
</form>

<a href="{{ route('admin.albums.index') }}">Back to Albums List</a>