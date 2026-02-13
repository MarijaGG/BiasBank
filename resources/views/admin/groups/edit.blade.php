<h1>Edit Group</h1>

@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.groups.update', $group) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label>Group Name:</label>
        <input type="text" name="name" value="{{ old('name', $group->name) }}">
    </div>

    <div>
        <label>Debut Date:</label>
        <input type="date" name="debut_date" value="{{ old('debut_date', $group->debut_date) }}">
    </div>

    <button type="submit">Update</button>
</form>

<br>
<a href="{{ route('admin.groups.index') }}">Back to Groups List</a>