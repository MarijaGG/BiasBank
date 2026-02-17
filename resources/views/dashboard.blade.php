<x-app-layout>
    <x-slot name="header">
        <h2 class="large-title">
            Welcome, {{ auth()->check() ? auth()->user()->name : 'user' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card overflow-hidden sm:rounded-lg">
                <div class="p-6">
                    {{ __("You're logged in!") }}

                    @if(!empty($collection) && $collection->count())
                        <div class="small-muted">Total collection value: ${{ number_format($collectionTotal, 2) }}</div>

                        <h3 class="mt-4 font-semibold">Your collection</h3>
                        <div class="collection-grid" style="margin-top:8px;">
                            @foreach($collection as $item)
                                <div class="collection-item">
                                    <a href="{{ route('photocards.show', $item->photocard) }}">
                                        <img src="{{ $item->photocard->photo ? asset('storage/' . $item->photocard->photo) : asset('images/photocard-placeholder.png') }}" alt="pc" class="img-photocard img-cover">
                                    </a>
                                    <div class="album-title">{{ $item->photocard->member->stage_name ?? $item->photocard->member->name }}</div>
                                    <div class="small-muted">{{ $item->condition }}</div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="mt-4">You have no photocards in your collection yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
