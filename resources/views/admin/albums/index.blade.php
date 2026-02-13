<h1>Albums</h1>

<a href="{{ route('admin.albums.create') }}">Add Album</a>

@if(session('success'))
    <p style="color:green;">{{ session('success') }}</p>
@endif

<table border="1">
<tr>
    <th>Image</th>
    <th>Name</th>
    <th>Group</th>
    <th>Release Date</th>
    <th>Tracks</th>
    <th>Actions</th>
</tr>

@foreach($albums as $album)
<tr>
    <td>
        @if($album->image)
            <img src="{{ asset('storage/'.$album->image) }}" width="80">
        @endif
    </td>
    <td>{{ $album->name }}</td>
    <td>{{ $album->group->name }}</td>
    <td>{{ $album->release_date }}</td>
    <td>{{ $album->track_count }}</td>
    <td>
        <a href="{{ route('admin.albums.edit', $album) }}">Edit</a>

        <form action="{{ route('admin.albums.destroy', $album) }}"
              method="POST"
              style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
        </form>
    </td>
</tr>
@endforeach

</table>

<br>
<a href="{{ route('admin.dashboard') }}" ">Back to dashboard</a>