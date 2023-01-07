@component('mail::message')
# {{$type == \App\Models\Contact::TYPE_OTHER ? $subject : \App\Models\Contact::getTypeLabel($type)}}
@if(!empty($name))
Nome: {{$name}}<br>
@endif
@if(!empty($email))
Email: {{$email}}<br>
@endif

Mensagem: {{$message}}
<br>
<br>
Obrigado,<br>
{{ config('app.name') }}
@endcomponent
