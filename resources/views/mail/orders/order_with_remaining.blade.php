@component('mail::message')
# Caro(a) Associado(a),

Após recebermos o seu pagamento fracionado, foi emitido novo pagamento do valor remanescente:

Entidade: {{$order->mb_ent}}<br>
Referência: {{$order->mb_ref}}<br>
Total: {{$order->total . '€'}}<br>

Para regularizar as quotas e passar a ter acesso a todas as funcionalidades e serviços da APAP deverá também efetuar este pagamento que poderá ser novamente fracionado.<br>

Poderá consultar o seu estado de regularização de quotas na sua <a href="{{route('orders.show',[$order->id,'associate' => $associate->id])}}">área reservada</a>.<br>

{{ config('app.name') }}
@endcomponent
