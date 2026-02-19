<x-app-layout>
    <x-slot name="header">
        <h2 class="large-title">Albums</h2>
    </x-slot>
    
    <br>

@if(empty($upcoming))
<form method="GET" action="{{ route('albums.index') }}" class="flex-gap" style="margin-bottom:16px;align-items:center;">
    <label class="small-muted" style="margin-right:8px">Sort by:</label>
    <select name="sort" class="dark-select">
        <option value="name" {{ (isset($sort) && $sort==='name') ? 'selected' : '' }}>Name</option>
        <option value="release_date" {{ (isset($sort) && $sort==='release_date') ? 'selected' : '' }}>Release date</option>
        <option value="tracks" {{ (isset($sort) && $sort==='tracks') ? 'selected' : '' }}>Track count</option>
        <option value="group" {{ (isset($sort) && $sort==='group') ? 'selected' : '' }}>Group</option>
    </select>

    <label class="small-muted" style="margin-left:10px;margin-right:8px">Direction:</label>
    <select name="direction" class="dark-select">
        <option value="asc" {{ (isset($direction) && $direction==='asc') ? 'selected' : '' }}>Asc</option>
        <option value="desc" {{ (isset($direction) && $direction==='desc') ? 'selected' : '' }}>Desc</option>
    </select>

    <label class="small-muted" style="margin-left:10px;margin-right:8px">Group:</label>
    <select name="group" class="dark-select">
        <option value="">All</option>
        @foreach($groups as $g)
            <option value="{{ $g->id }}" {{ (isset($groupFilter) && $groupFilter == $g->id) ? 'selected' : '' }}>{{ $g->name }}</option>
        @endforeach
    </select>

    <button type="submit" class="btn-dark" style="margin-left:12px">Apply</button>
</form>
@endif

<div class="grid-wrap">
    @foreach($albums as $album)
        <div class="center" style="width:160px;">
            <a href="{{ route('albums.show', $album) }}">
                <img src="{{ $album->image ? asset('storage/' . $album->image) : asset('images/album-placeholder.png') }}" alt="{{ $album->name }}" class="img-album img-cover">
                <div class="album-title">{{ $album->name }}</div>
            </a>
        </div>
    @endforeach
</div>

</x-app-layout>
