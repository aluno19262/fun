@component('mail::message')
# {{$declaration->declarationTemplate->name}} - Ref {{$declaration->id}} - Pagamento Efetuado
O associado {{$order->associate->name}} efetuou o pagamento do seu <a href="{{route('declarations.show',[$order->declaration,'associate' => $order->associate->id])}}">pedido de </a> {{$declaration->declarationTemplate->name}} com a referência {{$declaration->id}}.<br>

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
