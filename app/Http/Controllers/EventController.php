<?php

namespace App\Http\Controllers;

use App\Events\UserJoinedEvent;
use App\Mail\EventJoinedCreator;
use App\Mail\EventJoinedUser;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Mail;

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
        $events = Event::paginate(4);
        return view('events.index', ['events' => $events]);
    }

    public function dashboard()
    {
        $events = Event::where('user_id', auth()->id())->paginate(4);
        return view('dashboard', ['events' => $events]);
    }



    public function show(Event $event) {
        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $this->authorize('edit', $event);

        return view('events.edit', compact('event'));
    }


    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);


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
        $this->authorize('delete', $event);


        if ($event->image) {
            $path = public_path('images/' . $event->image);
            if (file_exists($path)) {
                unlink($path);
            } else {
                dd('Le fichier n\'existe pas à cet emplacement: ' . $path);
            }
        }
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Événement supprimé avec succès.');
    }

    public function participate(Event $event)
    {
        $user = auth()->user();
        auth()->user()->eventsParticipated()->attach($event);

        event(new UserJoinedEvent($user, $event));

        return back();
    }

    public function unparticipate(Event $event)
    {
        auth()->user()->eventsParticipated()->detach($event);
        return back();
    }






}
