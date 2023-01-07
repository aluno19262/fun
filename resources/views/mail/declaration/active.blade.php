@component('mail::message')
# Declaração de {{$declaration->declarationTemplate->name}}

Foi emitida a declaração de {{$declaration->declarationTemplate->name}} com a referência {{$declaration->declaration_number}}.<br>
Após o seu pagamento, foi emitida a declaração de {{$declaration->declarationTemplate->name}} com a referência {{$declaration->declaration_number}}.<br>

@component('mail::button', ['url' => route('declarations.show',[$declaration,'associate' => $declaration->associate->id])])
    {{ __('VER DECLARAÇÃO') }}
@endcomponent
<br>
Obrigado,<br>
{{ config('app.name') }}
@endcomponent
