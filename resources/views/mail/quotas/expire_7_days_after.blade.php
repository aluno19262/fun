@component('mail::message')
# Cara(o) associada(o),

Terminou ontem o prazo para regularização das suas quotas para este ano.

A partir deste momento, as suas declarações emitidas perderam validade assim como os seus privilégios de associado foram revogados.

Poderá ainda regularizar a sua situação efetuando o pagamento através dos seguintes dados:
Entidade: {{$order->mb_ent}}<br>
Referência: {{$order->mb_ref}}<br>
Total: {{$order->total . '€'}}<br>

Em alternativa, poderá aceder à sua área reservada e consultar dados de pagamento para o semestre ou pagamento através de MBWay: <a href="{{route('home')}}"> associados.apap.pt</a>

{{ config('app.name') }}
@endcomponent
