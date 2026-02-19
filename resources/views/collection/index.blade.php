<x-app-layout>
    <x-slot name="header">
        <h2 class="large-title">My collection</h2>
    </x-slot>

@if(isset($collectionTotal))
    <div class="collection-total">Total collection value: {{ number_format($collectionTotal, 2) }} USD</div>
@endif

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
            <option value="{{ $g->id }}" data-members='@json($g->members->map(function($m){ return ['id'=>$m->id,'name'=>$m->stage_name ?? $m->name]; }))' {{ (string)$g->id === (string)$groupFilter ? 'selected' : '' }}>{{ $g->name }}</option>
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

                <div class="display-info" style="margin-top:8px;">
                    <div class="small-muted">Price paid: {{ $up->purchase_price !== null ? number_format($up->purchase_price, 2) : '—' }} USD</div>
                    <div style="margin-top:8px; display:flex; gap:8px; justify-content:center; align-items:center;">
                        <button type="button" class="btn" data-action="edit" data-id="{{ $up->id }}">Edit</button>
                        <form method="POST" action="{{ route('collection.destroy', $up) }}" onsubmit="return confirm('Remove from your collection?')" style="margin:0;" data-role="remove" data-id="{{ $up->id }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn" type="submit">Remove</button>
                        </form>
                    </div>
                </div>

                <div id="edit-form-{{ $up->id }}" class="edit-form" style="display:none; margin-top:8px; width:100%;">
                    <form method="POST" action="{{ route('collection.update', $up) }}">
                        @csrf
                        @method('PATCH')
                        <input type="number" name="purchase_price" step="0.01" min="0" class="dark-select" placeholder="Price" value="{{ old('purchase_price', $up->purchase_price) }}" style="width:100%;">
                        <select name="status" class="dark-select" style="width:100%; margin-top:6px;">
                            <option value="have" {{ $up->status === 'have' ? 'selected' : '' }}>Have</option>
                            <option value="want" {{ $up->status === 'want' ? 'selected' : '' }}>Want</option>
                        </select>
                        <div style="display:flex; gap:8px; justify-content:center; margin-top:8px;">
                            <button class="btn-dark" type="submit">Save</button>
                            <button type="button" class="btn" data-action="cancel" data-id="{{ $up->id }}">Cancel</button>
                        </div>
                    </form>
                </div>

                
            </div>
        @endforeach
    @endif
</div>

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

                <div class="display-info" style="margin-top:8px;">
                    <div style="margin-top:8px; display:flex; gap:8px; justify-content:center; align-items:center;">
                        <button type="button" class="btn" data-action="edit" data-id="{{ $up->id }}">Edit</button>
                        <form method="POST" action="{{ route('collection.destroy', $up) }}" onsubmit="return confirm('Remove from your collection?')" style="margin:0;" data-role="remove" data-id="{{ $up->id }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn" type="submit">Remove</button>
                        </form>
                    </div>
                </div>

                <div id="edit-form-{{ $up->id }}" class="edit-form" style="display:none; margin-top:8px; width:100%;">
                    <form method="POST" action="{{ route('collection.update', $up) }}">
                        @csrf
                        @method('PATCH')
                        <input type="number" name="purchase_price" step="0.01" min="0" class="dark-select" placeholder="Price" value="{{ old('purchase_price', $up->purchase_price) }}" style="width:100%;">
                        <select name="status" class="dark-select" style="width:100%; margin-top:6px;">
                            <option value="have" {{ $up->status === 'have' ? 'selected' : '' }}>Have</option>
                            <option value="want" {{ $up->status === 'want' ? 'selected' : '' }}>Want</option>
                        </select>
                        <div style="display:flex; gap:8px; justify-content:center; margin-top:8px;">
                            <button class="btn-dark" type="submit">Save</button>
                            <button type="button" class="btn" data-action="cancel" data-id="{{ $up->id }}">Cancel</button>
                        </div>
                    </form>
                </div>

                
            </div>
        @endforeach
    @endif
</div>

</x-app-layout>

<script>
document.addEventListener('click', function(e){
    var el = e.target;
    var action = el.getAttribute('data-action');
    if(!action) return;
    var id = el.getAttribute('data-id');
    if(action === 'edit' && id){
        var form = document.getElementById('edit-form-' + id);
        if(form){ form.style.display = 'block'; }
        el.style.display = 'none';
        var removeForm = document.querySelector('[data-role="remove"][data-id="'+id+'"]');
        if(removeForm){ removeForm.style.display = 'none'; }
    }
    if(action === 'cancel' && id){
        var form = document.getElementById('edit-form-' + id);
        if(form){ form.style.display = 'none'; }
        var editBtn = document.querySelector('[data-action="edit"][data-id="'+id+'"]');
        if(editBtn){ editBtn.style.display = 'inline-block'; }
        var removeForm = document.querySelector('[data-role="remove"][data-id="'+id+'"]');
        if(removeForm){ removeForm.style.display = ''; }
    }
});


document.addEventListener('DOMContentLoaded', function(){
    var groupSelect = document.querySelector('select[name="group"]');
    var memberSelect = document.querySelector('select[name="member"]');

    if(!groupSelect || !memberSelect) return;

    groupSelect.addEventListener('change', function(){
        var groupId = this.value;
        memberSelect.innerHTML = '<option value="">All members</option>';
        if(!groupId) return;

        var opt = this.querySelector('option[value="' + groupId + '"]');
        if(!opt) return;
        var membersJson = opt.getAttribute('data-members');
        if(!membersJson) return;
        try{
            var list = JSON.parse(membersJson);
            list.forEach(function(m){
                var o = document.createElement('option');
                o.value = m.id;
                o.textContent = m.name;
                memberSelect.appendChild(o);
            });
        } catch(err) {

        }
    });
});
</script>
