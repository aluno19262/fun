@component('mail::message')
# Cara(o) associada(o),

Está já a decorrer o prazo de renovação das suas quotas para este ano.<br>
Relembramos que a validade das suas declarações emitidas bem como os privilégios de associado dependem da regularização de quotas.<br>
Poderá efetuar o pagamento para este ano através dos seguintes dados:<br>
Entidade: {{$order->mb_ent}}<br>
Referência: {{$order->mb_ref}}<br>
Total: {{$order->total . '€'}}<br>

Em alternativa, poderá aceder à sua área reservada e consultar dados de pagamento para o semestre ou pagamento através de MBWay: <a href="{{route('home')}}"> associados.apap.pt</a>

{{ config('app.name') }}
@endcomponent
