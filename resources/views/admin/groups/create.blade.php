<h1>Create Group</h1>

@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.groups.store') }}" method="POST">
    @csrf

    <div>
        <label>Group Name:</label>
        <input type="text" name="name" value="{{ old('name') }}">
    </div>

    <div>
        <label>Debut Date:</label>
        <input type="date" name="debut_date" value="{{ old('debut_date') }}">
    </div>

    <button type="submit">Create</button>
</form>

<br>
<a href="{{ route('admin.groups.index') }}">Back to Groups List</a>