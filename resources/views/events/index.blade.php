@extends('layouts.app')

@section('content')
    <div class="relative min-h-screen bg-dots-darker  bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <div class="container mx-auto p-6">
            <h1 class="text-2xl font-bold mb-4">Liste des événements</h1>

            @if($events->isEmpty())
                <p class="text-gray-600 dark:text-gray-400">Il n'y a pas d'événements pour le moment.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($events as $event)
                        <a href="{{ route('event.show', $event) }}" class=" items-center grid bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden mb-4 md:mb-0">
                            @if($event->image)
                                <div class="flex  justify-center" style="height: 300px; width: 300px;">
                                    <img src="{{ asset('images/' . $event->image) }}" alt="{{ $event->title }}" style="max-width: 100%; max-height: 100%;">
                                </div>
                            @endif
                            <div class="p-4">
                                <h2 class="text-xl font-semibold mb-2">{{ $event->title }}</h2>
                                <p class="text-gray-600 dark:text-gray-400 mb-2">{{ \Carbon\Carbon::parse($event->date)->format('d/m/Y H:i') }}</p>
                                <p class="text-gray-500 dark:text-gray-300 line-clamp-2">{{ substr($event->description, 0, 250) }}...</p>
                                <p class="mt-2 text-gray-700 dark:text-gray-300">Créé par : {{ $event->user->name }}</p>
                            </div>
                        </a>


                    @endforeach
                    </div>
                @endif
            </div>



    </div>
@endsection
