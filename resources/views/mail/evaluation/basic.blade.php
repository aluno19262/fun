@component('mail::message')
# A Aguardar Aprovação

@if(is_null($secretariado))
    A sua candidatura foi submetida.
    Você aguarda agora aprovação por parte do secretariado.
@else
    O associado estudante aguarda aprovação:
    Nome : {{$associate->name}}
    Email : {{$associate->email}}
    Telefone : {{$associate->phone}}
    Cartão de Cidadão : {{$associate->cc_number}}
    NIF : {{$associate->vat}}
@endif

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
