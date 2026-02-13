<h1>Edit Photocard</h1>

<form method="POST" action="{{ route('admin.photocards.update', $photocard) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label>Group:</label>
    <select name="group_id">
        @foreach($groups as $group)
            <option value="{{ $group->id }}" 
                {{ $photocard->group_id == $group->id ? 'selected' : '' }}>
                {{ $group->name }}
            </option>
        @endforeach
    </select>

    <label>Member:</label>
    <select name="member_id">
        @foreach($members as $member)
            <option value="{{ $member->id }}"
                {{ $photocard->member_id == $member->id ? 'selected' : '' }}>
                {{ $member->stage_name }}
            </option>
        @endforeach
    </select>

    <label>Album:</label>
    <select name="album_id">
        @foreach($albums as $album)
            <option value="{{ $album->id }}"
                {{ $photocard->album_id == $album->id ? 'selected' : '' }}>
                {{ $album->name }}
            </option>
        @endforeach
    </select>

    <label>Version:</label>
    <input type="text" name="version" value="{{ $photocard->version }}">

    <label>Price:</label>
    <input type="number" step="0.01" name="average_price" value="{{ $photocard->average_price }}">


    <p>Current Photo:</p>
    <img src="{{ asset('storage/' . $photocard->photo) }}" width="100">

    <label>Change Photo:</label>
    <input type="file" name="photo">
<br>
    <button type="submit">Update</button>
</form>

<br>
<a href="{{ route('admin.photocards.index') }}">Back to Photocards List</a>