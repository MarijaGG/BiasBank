<x-app-layout>

<h1 class="large-title">Photocard</h1>

<div class="flex-gap">
    <div>
        @if(isset($ownedCount) && $ownedCount > 0)
            <div class="small-muted" style="margin-bottom:8px;font-weight:600;">You have {{ $ownedCount }} of this photocard in your collection.</div>
        @endif
        <img src="{{ $photocard->photo ? asset('storage/' . $photocard->photo) : asset('images/photocard-placeholder.png') }}" alt="Photocard" class="img-photocard img-cover" style="width:220px;height:300px;">
    </div>

    <div>
        <p><strong>Member:</strong> <a href="{{ route('members.show', $photocard->member) }}">{{ $photocard->member->stage_name ?? $photocard->member->name }}</a></p>
        <p><strong>Album:</strong> <a href="{{ route('albums.show', $photocard->album) }}">{{ $photocard->album->name ?? 'Album' }}</a></p>
        <p><strong>Version:</strong> {{ $photocard->version ?? '—' }}</p>
        <p><strong>Average price:</strong> {{ $photocard->average_price ?? '—' }}</p>

        @auth
            <hr class="sep">
            <form method="POST" action="{{ route('photocards.collect', $photocard) }}" class="photocard-form">
                @csrf

                <div>
                    <label class="block">Condition</label>
                    <select name="condition" required class="border rounded px-2 py-1">
                        <option value="Near Mint">Near Mint</option>
                        <option value="Excellent">Excellent</option>
                        <option value="Good">Good</option>
                        <option value="Fair">Fair</option>
                    </select>
                </div>

                <div style="margin-top:8px;">
                    <label class="block">Purchase price (optional)</label>
                    <input type="number" step="0.01" name="purchase_price" class="border rounded px-2 py-1">
                </div>
                <div style="margin-top:12px;">
                    <button type="submit" class="btn">Add to my collection</button>
                </div>
            </form>
        @else
            <p><a href="{{ route('login') }}">Log in</a> to add this photocard to your collection.</p>
        @endauth
    </div>
</div>

</x-app-layout>
