<h1>Groups</h1>

<a href="{{ route('admin.groups.create') }}">Add New Group</a>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<table border="1">
    <tr>
        <th>Name</th>
        <th>Debut Date</th>
        <th>Actions</th>
    </tr>

    @foreach($groups as $group)
        <tr>
            <td>{{ $group->name }}</td>
            <td>{{ $group->debut_date }}</td>
            <td>
                <a href="{{ route('admin.groups.edit', $group) }}">Edit</a>

                <form action="{{ route('admin.groups.destroy', $group) }}"
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