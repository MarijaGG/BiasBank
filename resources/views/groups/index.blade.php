<x-app-layout>

<h1 class="large-title">Groups</h1>

<form method="GET" action="{{ route('groups.index') }}" class="flex-gap" style="margin-bottom:20px;align-items:center;">

    <label class="small-muted" style="margin-right:8px">Sort by:</label>
    <select name="sort" class="dark-select">
        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
        <option value="debut" {{ request('sort') == 'debut' ? 'selected' : '' }}>Debut Date</option>
        <option value="members" {{ request('sort') == 'members' ? 'selected' : '' }}>Member Count</option>
    </select>

    <select name="direction" class="dark-select" style="margin-left:10px">
        <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
        <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Descending</option>
    </select>

    <button type="submit" class="btn-dark" style="margin-left:12px">Sort</button>
</form>

<div class="groups-grid">

@foreach($groups as $group)
    <a href="{{ route('groups.show', $group) }}" class="group-card">
        <strong>{{ $group->name }}</strong>
    </a>
@endforeach

</div>

</x-app-layout>
