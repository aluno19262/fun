@component('mail::message')
# Candidatura Rejeitada

A sua candidatura foi rejeitada.<br><br>
@if(!empty($associate->evaluation_note))
Motivo da rejeição : {!! $associate->evaluation_note !!}}<br><br>
@elseif(!empty($associate->evaluation_note_phase_1))
    Motivo da rejeição : {!! $associate->evaluation_note_phase_1 !!}}<br><br>
@endif
Pode alterar os dados do seu perfil e submeter uma nova candidatura em <a href="{{route('home')}}">APAP</a>

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
