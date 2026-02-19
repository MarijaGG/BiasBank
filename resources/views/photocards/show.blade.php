<x-app-layout>

<h1 class="large-title">Photocard</h1>

<div class="flex-gap">
    <div>
        @if(isset($ownedCount) && $ownedCount > 0)
            <div class="small-muted" style="margin-bottom:8px;font-weight:600;">You have {{ $ownedCount }} of this photocard in your collection.</div>
        @elseif(isset($want) && $want)
            <div class="small-muted" style="margin-bottom:8px;font-weight:600;">You want this photocard.</div>
        @endif
        <img src="{{ $photocard->photo ? asset('storage/' . $photocard->photo) : asset('images/photocard-placeholder.png') }}" alt="Photocard" class="img-photocard img-cover" style="width:220px;height:300px;">
    </div>

    <div>
        <p><strong>Member:</strong> <a href="{{ route('members.show', $photocard->member) }}">{{ $photocard->member->stage_name ?? $photocard->member->name }}</a></p>
        <p><strong>Album:</strong> <a href="{{ route('albums.show', $photocard->album) }}">{{ $photocard->album->name ?? 'Album' }}</a></p>
        <p><strong>Version:</strong> {{ $photocard->version ?? '—' }}</p>
        <p><strong>Average price:</strong> {{ $photocard->average_price ?? '—' }} USD</p>

        @auth
            <hr class="sep">
            <div class="flex-gap" style="align-items:flex-start;">
                <div class="inline-row">
                    <form id="have-form" method="POST" action="{{ route('photocards.collect', $photocard) }}" class="photocard-form" style="min-width:240px;">
                        @csrf

                        <div>
                            <label class="block">Condition</label>
                            <select name="condition" required class="dark-select">
                                <option value="Near Mint">Near Mint</option>
                                <option value="Excellent">Excellent</option>
                                <option value="Good">Good</option>
                                <option value="Fair">Fair</option>
                            </select>
                        </div>

                        <div style="margin-top:8px;">
                            <label class="block">Purchase price (optional)</label>
                            <input type="number" step="0.01" name="purchase_price" placeholder="0.00" class="dark-select">
                        </div>

                    </form>

                    <div class="actions" style="display:flex;gap:10px;align-items:flex-start;">
                        <button type="button" onclick="document.getElementById('have-form').submit()" class="btn">Add to Have</button>

                        <form method="POST" action="{{ route('photocards.want', $photocard) }}">
                            @csrf
                            <button type="submit" class="btn-dark">Add to Want</button>
                        </form>
                    </div>
                </div>
            </div>

        @else
            <p><a href="{{ route('login') }}">Log in</a> to add this photocard to your collection.</p>
        @endauth

    </div>
</div>

</x-app-layout>
 
