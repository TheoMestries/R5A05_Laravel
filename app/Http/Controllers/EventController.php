<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $data['image'] = $imageName;
        }

        $data['user_id'] = auth()->id();


        Event::create($data);

        return redirect()->route('events.index')->with('success', 'Événement créé avec succès.');
    }

    public function index()
    {
        $events = Event::all();
        return view('events.index', ['events' => $events]);
    }

    public function dashboard()
    {
        $events = Event ::where('user_id', auth()->id())->get();
        return view('dashboard', ['events' => $events]);
    }



    public function show(Event $event) {
        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        if (auth()->user()->id != $event->user_id) {
            return redirect()->back()->with('error', 'Vous n\'avez pas le droit de modifier cet événement.');
        }

        return view('events.edit', compact('event'));
    }


    public function update(Request $request, Event $event)
    {
        if (auth()->user()->id != $event->user_id) {
            return redirect()->back()->with('error', 'Vous n\'avez pas le droit de modifier cet événement.');
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'image' => 'nullable|image'
        ]);


        if ($request->hasFile('image')) {
            if ($request->hasFile('image')) {
                // Si une nouvelle image est téléchargée, supprimez l'ancienne image
                if ($event->image) {
                    $path = public_path('images/' . $event->image);
                    if (file_exists($path)) {
                        unlink($path);
                    } else {
                        dd('Le fichier n\'existe pas à cet emplacement: ' . $path);
                    }
                }

                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('images'), $imageName);
                $data['image'] = $imageName;

            }

            $event->update($data);

            return redirect()->route('events.index', $event->id)->with('success', 'Événement mis à jour avec succès.');
        }
    }

    public function destroy(Event $event)
    {
        // Vérifiez si l'utilisateur a le droit de supprimer l'événement
        if (auth()->user()->id != $event->user_id) {
            return redirect()->back()->with('error', 'Vous n\'avez pas le droit de supprimer cet événement.');
        }

        // Supprimez l'image de l'événement

        if ($event->image) {
            $path = public_path('images/' . $event->image);
            if (file_exists($path)) {
                unlink($path);
            } else {
                dd('Le fichier n\'existe pas à cet emplacement: ' . $path);
            }
        }
        // Supprimez l'événement
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Événement supprimé avec succès.');
    }






}
