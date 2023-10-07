@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-10 px-4 lg:px-0 max-w-md"> <!-- Ajout de max-w-md pour réduire la taille du conteneur -->
        <h1 class="mb-4 text-2xl font-bold text-center">Créer un événement</h1>

        <form action="{{ route('events.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
                <input type="text" class="mt-1 p-2 w-full border rounded-md" id="title" name="title" required>
                @error('title')
                <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea class="mt-1 p-2 w-full border rounded-md" id="description" name="description" rows="3" required></textarea>
                @error('description')
                <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-6">
                <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                <input type="datetime-local" class="mt-1 p-2 w-full border rounded-md" id="date" name="date" required>
                @error('date')
                <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-6">
                <label for="image" class="block text-sm font-medium text-gray-700">Image de l'événement</label>
                <input type="file" id="image" name="image" class="mt-1 p-2 w-full border rounded-md">
                @error('image')
                <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-center">
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded">Créer</button>
            </div>
        </form>
    </div>
@endsection
