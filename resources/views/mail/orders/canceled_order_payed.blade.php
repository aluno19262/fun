@component('mail::message')
# Pagamento Canelado foi pago

O pagamento {{"#$order->id"}} que foi anteriormente cancelado, foi agora pago.

Contacte o associado {{$order->associate->associate_number}} para mais informações.

{{ config('app.name') }}
@endcomponent
