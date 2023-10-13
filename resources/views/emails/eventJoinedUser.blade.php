Bonjour, <br> <br>

Vous avez rejoint l'événement "{{ $event->title }}" prévu le {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y H:i') }}.<br><br>

Description : {{ $event->description }} <br><br>

Merci, <br>
L'équipe de {{ config('app.name') }}
