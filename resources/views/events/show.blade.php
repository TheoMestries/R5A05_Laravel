@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6 h-screen">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden p-6 space-y-4">
            <div class="w-screen h-screen">
                <div class="flex justify-center">
                    <img src="{{ asset('images/' . $event->image) }}" alt="{{ $event->title }}" width="500">
                </div>

                <!-- Title and Date -->
                <div class="flex justify-between items-center mt-4">
                    <div>
                        <h2 class="text-xl font-semibold mb-2">Intitulé de l'évènement</h2>
                        <h1 class="text-3xl font-bold">{{ $event->title }}</h1>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold mb-2">Date de l'évènement</h2>
                        <span class="text-gray-600 dark:text-gray-400">{{ \Carbon\Carbon::parse($event->date)->format('d/m/Y H:i') }}</span>
                    </div>
                </div>

                <!-- Description -->
                <div class="text-gray-700 dark:text-gray-300 mt-4">
                    <h2 class="text-xl font-semibold mb-2">Description de l'évènement</h2>
                    {{ $event->description }}
                </div>

                <!-- Creator -->
                <div class="mt-4 text-right text-sm text-gray-600 dark:text-gray-400">
                    <h2 class="text-xl font-semibold mb-2">Créateur de l'évènement</h2>
                    Créé par : {{ $event->user->name }}
                </div>

                <div class="mt-4 text-right text-sm text-gray-600 dark:text-gray-400">
                <h2 class="text-xl font-semibold mb-2">Nombre de participants : {{ $event->participants->count() }}</h2>
                </div>

                <div class="mt-4 text-right text-sm text-gray-600 dark:text-gray-400">
                    <h2 class="text-xl font-semibold mb-2">Participants : </h2>
                    <ul>
                        @foreach($event->participants as $participant)
                            <li>{{ $participant->name }}</li>
                        @endforeach
                    </ul>
                </div>

                @auth
                    @if (auth()->user()->id == $event->user->id)
                        <div class="mt-4 text-center">
                            <a href="{{ route('event.edit', $event->id) }}" class="bg-blue-500 hover:bg-blue-600 text-black px-4 py-2 rounded shadow">
                                Modifier l'événement
                            </a>
                        </div>
                        <form
                            action="{{ route('events.destroy', $event->id) }}"
                            method="POST"
                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?');"
                            class="mt-4"
                        >
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Supprimer l'événement</button>
                        </form>
                    @endif
                @endauth
                @if(auth()->check() && !auth()->user()->eventsParticipated->contains($event))
                    <form action="{{ route('events.participate', $event) }}" method="POST">
                        @csrf
                        <button type="submit">Je participe</button>
                    </form>
                @elseif(auth()->check())
                    <form action="{{ route('events.unparticipate', $event) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Je ne participe plus</button>
                    </form>
                @endif


            </div>
        </div>
    </div>
@endsection
