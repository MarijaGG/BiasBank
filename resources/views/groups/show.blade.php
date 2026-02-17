<x-app-layout>

<div class="card">
    <h1 class="large-title">{{ $group->name }}</h1>

    <p><strong>Debut date:</strong> {{ $group->debut_date }}</p>
    <p><strong>Members:</strong> {{ $group->members->count() }}</p>

    <hr class="sep">

    <h2 class="group-title">Members</h2>

    <div class="group-members">
        @foreach($group->members as $member)
            <div class="member-card">
                <a href="{{ route('members.show', $member) }}">
                    <img src="{{ $member->image ? asset('storage/' . $member->image) : asset('images/member-placeholder.png') }}" alt="{{ $member->stage_name ?? $member->name ?? 'Member' }}" class="img-member img-cover">
                </a>
                <div class="member-name">{{ $member->stage_name ?? $member->name }}</div>
            </div>
        @endforeach
    </div>

    <hr class="sep">

    <h2 class="group-title">Albums</h2>

    <div class="grid-wrap">
        @foreach($group->albums as $album)
            <div class="center album-card">
                <a href="{{ route('albums.show', $album) }}">
                    <img src="{{ $album->image ? asset('storage/' . $album->image) : asset('images/album-placeholder.png') }}" alt="{{ $album->name }}" class="img-album img-cover">
                    <div class="album-title">{{ $album->name }}</div>
                </a>
            </div>
        @endforeach
    </div>

</div>

</x-app-layout>
