@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6 h-screen">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden p-6 space-y-4 w-full h-full">
            <h2 class="text-2xl font-bold mb-4 text-center">Modifier l'événement</h2>

            <form action="{{ route('event.update', $event->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Image -->
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('images/' . $event->image) }}" alt="{{ $event->title }}" width="300">
                </div>

                <!-- Upload Image -->
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">Changer l'image</label>
                    <input type="file" id="image" name="image" class="mt-1 p-2 border rounded-md">
                </div>

                <!-- Title -->
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Intitulé de l'évènement</label>
                    <input type="text" id="title" name="title" value="{{ $event->title }}" required class="mt-1 p-2 w-full border rounded-md">
                </div>

                <!-- Date -->
                <div class="mb-4">
                    <label for="date" class="block text-sm font-medium text-gray-700">Date de l'évènement</label>
                    <input type="datetime-local" id="date" name="date" value="{{ \Carbon\Carbon::parse($event->date)->format('Y-m-d\TH:i') }}" required class="mt-1 p-2 w-full border rounded-md">
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description de l'évènement</label>
                    <textarea id="description" name="description" rows="4" required class="mt-1 p-2 w-full border rounded-md">{{ $event->description }}</textarea>
                </div>

                <!-- Submit Button -->
                <div class="mt-4">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-black px-4 py-2 rounded shadow">
                        Mettre à jour l'événement
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
