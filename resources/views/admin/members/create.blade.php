<h1>Create Member</h1>

<form action="{{ route('admin.members.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label>Group:</label>
    <select name="group_id">
        @foreach($groups as $group)
            <option value="{{ $group->id }}">{{ $group->name }}</option>
        @endforeach
    </select>

    <br>

    <label>Stage Name:</label>
    <input type="text" name="stage_name">

    <br>

    <label>Real Name:</label>
    <input type="text" name="real_name">

    <br>

    <label>Birthday:</label>
    <input type="date" name="birthday">

    <br>

    <label>Image:</label>
    <input type="file" name="image">

    <br><br>

    <button type="submit">Create</button>
</form>

<br>
<a href="{{ route('admin.members.index') }}">Back to Members List</a>