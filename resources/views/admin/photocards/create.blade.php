<h1>Add Photocard</h1>

<form method="POST" action="{{ route('admin.photocards.store') }}" enctype="multipart/form-data">
    @csrf

    <label>Member:</label>
    <select name="member_id" id="memberSelect">
    @foreach($members as $member)
        <option value="{{ $member->id }}" data-group="{{ $member->group_id }}">
            {{ $member->stage_name }}
        </option>
    @endforeach
    </select>

<br>
    <label>Album:</label>
    <select name="album_id" id="albumSelect">
    @foreach($albums as $album)
        <option value="{{ $album->id }}" data-group="{{ $album->group_id }}">
            {{ $album->name }}
        </option>
    @endforeach
    </select>

    <label>Version:</label>
    <input type="text" name="version">
<br>
    <label>Average Price:</label>
    <input type="number" step="0.01" name="average_price">
<br>
    <label>Photo:</label>
    <input type="file" name="photo">
<br>
    <button type="submit">Save</button>
</form>

<br>
<a href="{{ route('admin.photocards.index') }}">Back to Photocards List</a>

<script>
document.getElementById('groupSelect').addEventListener('change', function () {

    let selectedGroup = this.value;

    let memberOptions = document.querySelectorAll('#memberSelect option');
    let albumOptions = document.querySelectorAll('#albumSelect option');

    // Reset selects
    document.getElementById('memberSelect').value = "";
    document.getElementById('albumSelect').value = "";

    // Filter Members
    memberOptions.forEach(option => {
        if (!option.dataset.group) return;

        option.style.display = option.dataset.group === selectedGroup ? 'block' : 'none';
    });

    // Filter Albums
    albumOptions.forEach(option => {
        if (!option.dataset.group) return;

        option.style.display = option.dataset.group === selectedGroup ? 'block' : 'none';
    });
});
</script>
