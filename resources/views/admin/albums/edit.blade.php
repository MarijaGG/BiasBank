<h1>Edit Album</h1>


<form action="{{ route('admin.albums.update', $album) }}"
      method="POST"
      enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div>
        <label>Group:</label>
        <select name="group_id">
            @foreach($groups as $group)
                <option value="{{ $group->id }}"
                    {{ $group->id == old('group_id', $album->group_id) ? 'selected' : '' }}>
                    {{ $group->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Album Name:</label>
        <input type="text" name="name" value="{{ old('name', $album->name) }}">
    </div>

    <div>
        <label>Release Date:</label>
        <input type="date" name="release_date" value="{{ old('release_date', $album->release_date) }}">
    </div>

    <div>
        <label>Track Count:</label>
        <input type="number" name="track_count" value="{{ old('track_count', $album->track_count) }}" min="0">
    </div>

    <div>
        <label>Title Track:</label>
        <input type="text" name="title_track" value="{{ old('title_track', $album->title_track) }}">
    </div>

    @if($album->image)
        <div>
            <p>Current Cover:</p>
            <img src="{{ asset('storage/'.$album->image) }}" width="120">
        </div>
    @endif

    <div>
        <label>Change Cover:</label>
        <input type="file" name="image">
    </div>

    <button type="submit">Update Album</button>
</form>

<a href="{{ route('admin.albums.index') }}">Back to Albums List</a>
