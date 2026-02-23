<h1>Members</h1>

<a href="{{ route('admin.members.create') }}">Add Member</a>

<table border="1">
<tr>
    <th>Image</th>
    <th>Emoji</th>
    <th>Stage Name</th>
    <th>Group</th>
    <th>Actions</th>
</tr>

@foreach($members as $member)
<tr>
    <td>
        @if($member->image)
            <img src="{{ $member->image_url }}" width="80">
        @endif
    </td>
    <td style="font-size:22px; text-align:center">{{ $member->emoji ?? '' }}</td>
    <td>{{ $member->stage_name }}</td>
    <td>{{ $member->group->name }}</td>
    <td>
        <a href="{{ route('admin.members.edit', $member) }}">Edit</a>

        <form action="{{ route('admin.members.destroy', $member) }}"
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