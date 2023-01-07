@component('mail::message')
Caro(a) {{$order->associate->name}},<br>
Recebemos o seu pagamento de quota da Associação Portuguesa de Arquitectos Paisagistas.<br>
Poderá consultar o seu pagamento e descarregar o recibo na sua <a href="{{route('orders.show',$order)}}">área de associado</a>.<br>

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
