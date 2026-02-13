<h1>Photocards</h1>

<a href="{{ route('admin.photocards.create') }}">Add Photocard</a>

<table border="1" cellpadding="10">
    <tr>
        <th>Photo</th>
        <th>Group</th>
        <th>Member</th>
        <th>Album</th>
        <th>Version</th>
        <th>Average Price</th>
        <th>Actions</th>
    </tr>

    @foreach($photocards as $card)
        <tr>
            <td>
                <img src="{{ asset('storage/'.$card->photo) }}" width="80">
            </td>
            <td>{{ $card->member->group->name }}</td>
            <td>{{ $card->member->stage_name }}</td>
            <td>{{ $card->album->name }}</td>
            <td>{{ $card->version }}</td>
            <td>${{ $card->average_price }}</td>
            <td>
                <a href="{{ route('admin.photocards.edit', $card) }}">Edit</a>

                <form method="POST" action="{{ route('admin.photocards.destroy', $card) }}" style="display:inline;">
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