@component('mail::message')
# A sua quota vai expirar

A sua quota expira hoje.<br>
@if(!empty($order->total_half))
Dados para pagamento de quotas anual: <br>
Entidade: {{$order->mb_ent}}<br>
Referência: {{$order->mb_ref}}<br>
Total: {{$order->total . '€'}}<br>
<br>
Ou se preferir pagar apenas um semestre:
Entidade: {{$order->mb_ent_half}}<br>
Referência: {{$order->mb_ref_half}}<br>
Total: {{$order->total_half . '€'}}<br>

@else
Dados para pagamento do segundo semestre: <br>
Entidade: {{$order->mb_ent}}<br>
Referência: {{$order->mb_ref}}<br>
Total: {{$order->total . '€'}}<br>
@endif

Ou clique <a href="{{route('home')}}"> aqui</a> para renovar.<br>

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
