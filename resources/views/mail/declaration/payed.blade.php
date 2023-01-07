@component('mail::message')
# Pagamento Recebido de {{$declaration->declarationTemplate->name}}

Recebemos o seu pagamento do pedido de <a href="{{route('orders.show',[$order,'associate' => $order->associate->id])}}">{{$declaration->declarationTemplate->name}}</a>  com a referência {{"#$order->id"}}, que irá agora ser analisado e despachado pela secretaria.

@if(!empty($order->invoice_link))
Poderá desde já descarregar o recibo do seu pagamento através do link:<a href="{{$order->invoice_link}}">{{$order->invoice_link}}</a><br>
@endif
Obrigado,<br>
{{ config('app.name') }}
@endcomponent
