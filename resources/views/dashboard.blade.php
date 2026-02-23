<x-app-layout>
    <x-slot name="header">
        <h2 class="large-title">
            Welcome, {{ auth()->check() ? auth()->user()->name : 'user' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    
            <div class="card overflow-hidden sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-xl font-semibold"><a href="{{ route('collection.index') }}" class="link">Go to your collection →</a></h3>
                </div>
            </div>

            <div class="card overflow-hidden sm:rounded-lg mb-6">
                <div class="p-6 dashboard-albums no-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-semibold">Recent albums</h3>
                        </div>
                        <a href="{{ route('albums.index') }}" class="link">View all albums →</a>
                    </div>

                    @if(!empty($recentAlbums) && $recentAlbums->count())
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4 mt-4">
                            @foreach($recentAlbums as $album)
                                <div class="collection-item">
                                    <a href="{{ route('albums.show', $album) }}">
                                        <img src="{{ $album->image_url }}" alt="album" class="img-album img-cover">
                                    </a>
                                    <div class="album-title mt-2">{{ $album->name }}</div>
                                    <div class="small-muted">{{ $album->release_date ? \Carbon\Carbon::parse($album->release_date)->toFormattedDateString() : '' }}</div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="mt-4">No recent albums yet.</p>
                    @endif
                </div>
            </div>

            <div class="card overflow-hidden sm:rounded-lg">
                <div class="p-6 dashboard-photocards no-hover">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold">Recently added photocards</h3>
                        <a href="{{ route('photocards.show', isset($recentPhotocards[0]) ? $recentPhotocards[0] : '#') }}" style="visibility:hidden">placeholder</a>
                    </div>

                    @if(!empty($recentPhotocards) && $recentPhotocards->count())
                        <div class="collection-grid mt-4" style="margin-top:8px;">
                            @foreach($recentPhotocards as $pc)
                                <div class="collection-item">
                                    <a href="{{ route('photocards.show', $pc) }}">
                                        <img src="{{ $pc->photo_url }}" class="img-photocard img-cover">
                                    </a>
                                    <div class="album-title">{{ $pc->member->stage_name ?? $pc->member->name }}</div>
                                    <div class="small-muted">{{ $pc->album->name ?? '' }}</div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="mt-4">No recently added photocards.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
