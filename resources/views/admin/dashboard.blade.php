<h1>Admin Dashboard</h1>
<p>Welcome, {{ auth()->user()->name }}</p>

<div style="display:flex; gap:20px;">
    <div style="border:1px solid #000; padding:20px;">
        <a href="{{ route('admin.groups.index') }}">Groups</a>
    </div>

    <div style="border:1px solid #000; padding:20px;">
        <a href="{{ route('admin.members.index') }}">Members</a>
    </div>

    <div style="border:1px solid #000; padding:20px;">
        <a href="{{ route('admin.albums.index') }}">Albums</a>
    </div>

    <div style="border:1px solid #000; padding:20px;">
        <a href="{{ route('admin.photocards.index') }}">Photocards</a>
    </div>
</div>

<br>

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>

<br>

<a href="{{ route('dashboard') }}" ">Back to dashboard</a>
