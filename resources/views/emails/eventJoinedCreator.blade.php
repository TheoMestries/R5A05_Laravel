Bonjour,<br><br>

{{ $participant->name }} a rejoint votre événement "{{ $event->title }}" prévu le {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y H:i') }}.<br><br>

Description : {{ $event->description }}<br><br>

Merci,<br>
L'équipe de {{ config('app.name') }}
