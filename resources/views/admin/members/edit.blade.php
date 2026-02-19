<h1>Edit Member</h1>


@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.members.update', $member) }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <div>
        <label>Group:</label>
        <select name="group_id">
            @foreach($groups as $group)
                <option value="{{ $group->id }}"
                    {{ $group->id == old('group_id', $member->group_id) ? 'selected' : '' }}>
                    {{ $group->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Stage Name:</label>
        <input type="text"
               name="stage_name"
               value="{{ old('stage_name', $member->stage_name) }}">
    </div>

    <div>
        <label>Real Name:</label>
        <input type="text"
               name="real_name"
               value="{{ old('real_name', $member->real_name) }}">
    </div>

    <div>
        <label>Birthday:</label>
        <input type="date"
               name="birthday"
               value="{{ old('birthday', $member->birthday) }}">
    </div>

    <div>
        <label>Nationality:</label>
        <input type="text" name="nationality" maxlength="100" value="{{ old('nationality', $member->nationality) }}">
    </div>

    <div>
        <label>Emoji (representative):</label>
        <input type="text" name="emoji" maxlength="10" value="{{ old('emoji', $member->emoji) }}">
    </div>

    @if ($member->image)
        <div>
            <p>Current Image:</p>
            <img src="{{ asset('storage/'.$member->image) }}" width="120">
        </div>
    @endif

    <div>
        <label>Change Image:</label>
        <input type="file" name="image">
    </div>

    <br>

    <button type="submit">Update Member</button>
</form>

<br>
<a href="{{ route('admin.members.index') }}">Back to Members List</a>