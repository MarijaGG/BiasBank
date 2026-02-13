<h1>Members</h1>

<a href="{{ route('admin.members.create') }}">Add Member</a>

<table border="1">
<tr>
    <th>Image</th>
    <th>Stage Name</th>
    <th>Group</th>
    <th>Actions</th>
</tr>

@foreach($members as $member)
<tr>
    <td>
        @if($member->image)
            <img src="{{ asset('storage/'.$member->image) }}" width="80">
        @endif
    </td>
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