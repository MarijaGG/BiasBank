
<x-app-layout>
	<x-slot name="header">
		<h2 class="large-title">{{ $album->name }}</h2>
	</x-slot>

   <br>
   
<div class="flex-gap">
	<div>
		<img src="{{ $album->image_url }}" alt="{{ $album->name }}" class="img-album img-cover">
	</div>

	<div>
		<p class="small-muted"><strong>Group:</strong> <a href="{{ route('groups.show', $album->group) }}">{{ $album->group->name ?? 'Group' }}</a></p>

		<p class="small-muted"><strong>Release date:</strong> {{ $album->release_date ?? $album->created_at->format('Y-m-d') }}</p>

		<p class="small-muted"><strong>Tracks:</strong> {{ $album->track_count ?? '—' }}</p>
		<p class="small-muted"><strong>Title track:</strong> {{ $album->title_track ?? '—' }}</p>
	</div>
</div>

<div style="margin-top:28px;">
	<h2>Photocards</h2>

	@php
		$pcs = $photocards ?? ($album->photocards ?? collect());
	@endphp

	<div style="margin-top:8px;">
		<form method="GET" action="{{ route('albums.show', $album) }}" style="margin-bottom:12px; display:flex; gap:8px; align-items:center;">
			<label class="small-muted" style="margin-right:8px">Member:</label>
			<select name="member" class="dark-select">
				<option value="">All</option>
				@foreach($members as $m)
					<option value="{{ $m->id }}" {{ (isset($memberFilter) && $memberFilter == $m->id) ? 'selected' : '' }}>{{ $m->stage_name ?? $m->name }}</option>
				@endforeach
			</select>

			<label class="small-muted" style="margin-right:8px; margin-left:6px">Version:</label>
			<select name="version" class="dark-select">
				<option value="">All</option>
				@if(!empty($versions) && $versions->count())
					@foreach($versions as $v)
						<option value="{{ $v }}" {{ (isset($versionFilter) && $versionFilter == $v) ? 'selected' : '' }}>{{ $v }}</option>
					@endforeach
				@endif
			</select>

			<button type="submit" class="btn-dark" style="margin-left:6px">Filter</button>
		</form>

		@if($pcs->count())
			<div class="photocard-grid">
				@foreach($pcs as $pc)
					<div class="photocard-item center">
						<a href="{{ route('photocards.show', $pc) }}">
							<img src="{{ $pc->photo_url }}" alt="Photocard" class="img-photocard img-cover">
							<div class="album-title">{{ $pc->version ?? '—' }}</div>
						</a>
					</div>
				@endforeach
			</div>
		@else
			<p style="margin-top:8px;">No photocards for this album.</p>
		@endif
	</div>
</div>

</x-app-layout>
