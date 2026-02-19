<x-app-layout>

<a href="{{ route('groups.show', $member->group) }}" class="back-link">← Back to group</a>

<h1 class="large-title">{{ $member->stage_name ?? $member->name }}</h1>

<div class="flex-gap">
    <div>
        <img src="{{ $member->image ? asset('storage/' . $member->image) : asset('images/member-placeholder.png') }}" alt="{{ $member->stage_name }}" class="img-member img-member-large img-cover">
    </div>

    <div>
        <p><strong>Real name:</strong> {{ $member->real_name }}</p>
        <p><strong>Group:</strong> <a href="{{ route('groups.show', $member->group) }}">{{ $member->group->name ?? $member->group->display_name ?? 'Group' }}</a></p>
        <p><strong>Birthday:</strong> {{ $member->birthday }}</p>
        <p><strong>Nationality:</strong> {{ $member->nationality ?? '—' }}</p>
        <p><strong>Representative Emoji:</strong> {{ $member->emoji ?? '—' }}</p>

    <br>

        <h3>Photocards</h3>
        <div class="photocard-grid">
            @foreach($member->photocards as $pc)
                <div class="photocard-item center" style="position:relative;">
                    <a href="{{ route('photocards.show', $pc) }}">
                        <img src="{{ $pc->photo ? asset('storage/' . $pc->photo) : asset('images/photocard-placeholder.png') }}" alt="Photocard" class="img-photocard img-cover">
                    </a>
                    @php $count = $ownedCounts[$pc->id] ?? 0; $wantFlag = $wanted[$pc->id] ?? false; @endphp
                    @if($count > 0)
                        <div class="pc-owned">Owned: {{ $count }}</div>
                    @elseif($wantFlag)
                        <div class="small-muted">Want</div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>

</x-app-layout>
