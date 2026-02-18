<x-app-layout>

<h1 class="large-title">My collection</h1>

<form method="GET" action="{{ route('collection.index') }}" class="flex-gap" style="margin-bottom:16px;align-items:center;">
    <label class="small-muted" style="margin-right:8px">Sort by:</label>

    <select name="sort" class="dark-select">
        <option value="created_at" {{ (isset($sort) && $sort==='created_at') ? 'selected' : '' }}>Added</option>
        <option value="member" {{ (isset($sort) && $sort==='member') ? 'selected' : '' }}>Member</option>
        <option value="album" {{ (isset($sort) && $sort==='album') ? 'selected' : '' }}>Album</option>
        <option value="price" {{ (isset($sort) && $sort==='price') ? 'selected' : '' }}>Price</option>
    </select>

    <label class="small-muted" style="margin-left:10px;margin-right:8px">Direction:</label>
    <select name="direction" class="dark-select">
        <option value="asc" {{ (isset($direction) && $direction==='asc') ? 'selected' : '' }}>Asc</option>
        <option value="desc" {{ (isset($direction) && $direction==='desc') ? 'selected' : '' }}>Desc</option>
    </select>

    <label class="small-muted" style="margin-left:10px;margin-right:8px">Group:</label>
    <select name="group" class="dark-select">
        <option value="">All groups</option>
        @foreach($groups as $g)
            <option value="{{ $g->id }}" {{ (string)$g->id === (string)$groupFilter ? 'selected' : '' }}>{{ $g->name }}</option>
        @endforeach
    </select>

    <label class="small-muted" style="margin-left:10px;margin-right:8px">Member:</label>
    <select name="member" class="dark-select">
        <option value="">All members</option>
        @foreach($members as $m)
            <option value="{{ $m->id }}" {{ (string)$m->id === (string)$memberFilter ? 'selected' : '' }}>{{ $m->stage_name ?? $m->name }}</option>
        @endforeach
    </select>

    <button class="btn-dark">Apply</button>
</form>

<!-- Have section -->
<h2 class="group-title" style="margin-top:12px">Have</h2>
<div class="grid-wrap" style="margin-bottom:18px">
    @if($haveItems->isEmpty())
        <div class="card">No items in Have.</div>
    @else
        @foreach($haveItems as $up)
            <div class="card" style="width:180px;text-align:center;">
                <img src="{{ $up->photocard->photo ? asset('storage/' . $up->photocard->photo) : asset('images/photocard-placeholder.png') }}" class="img-photocard img-cover" style="width:120px;height:156px;" alt="pc">
                <div style="margin-top:8px;font-weight:700;">{{ $up->photocard->member->stage_name ?? $up->photocard->member->name }}</div>
                <div class="small-muted">{{ $up->photocard->album->name ?? '' }}</div>
                <div class="small-muted" style="margin-top:6px;">Price paid: {{ $up->purchase_price !== null ? number_format($up->purchase_price, 2) : '—' }}</div>
                <div style="margin-top:8px;">
                    <form method="POST" action="{{ route('collection.destroy', $up) }}" onsubmit="return confirm('Remove from your collection?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn" type="submit">Remove</button>
                    </form>
                </div>
            </div>
        @endforeach
    @endif
</div>

<!-- Want section -->
<h2 class="group-title">Want</h2>
<div class="grid-wrap">
    @if($wantItems->isEmpty())
        <div class="card">No items in Want.</div>
    @else
        @foreach($wantItems as $up)
            <div class="card" style="width:180px;text-align:center;">
                <img src="{{ $up->photocard->photo ? asset('storage/' . $up->photocard->photo) : asset('images/photocard-placeholder.png') }}" class="img-photocard img-cover" style="width:120px;height:156px;" alt="pc">
                <div style="margin-top:8px;font-weight:700;">{{ $up->photocard->member->stage_name ?? $up->photocard->member->name }}</div>
                <div class="small-muted">{{ $up->photocard->album->name ?? '' }}</div>
                <div class="small-muted" style="margin-top:6px;">Price paid: {{ $up->purchase_price !== null ? number_format($up->purchase_price, 2) : '—' }}</div>
                <div style="margin-top:8px;">
                    <form method="POST" action="{{ route('collection.destroy', $up) }}" onsubmit="return confirm('Remove from your collection?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn" type="submit">Remove</button>
                    </form>
                </div>
            </div>
        @endforeach
    @endif
</div>

</x-app-layout>
