
@component('mail::message')
# Cara(o) associada(o),
Aproxima-se o prazo de renovação das suas quotas para o próximo ano.<br>
Poderá desde já efetuar o pagamento para o ano de {{\Carbon\Carbon::today()->addYear()->year}} através dos seguintes dados:<br>
Entidade: {{$order->mb_ent}}<br>
Referência: {{$order->mb_ref}}<br>
Total: {{$order->total . '€'}}<br>

Em alternativa, poderá aceder à sua área reservada e consultar dados de pagamento para o semestre ou pagamento através de MBWay: <a href="{{route('home')}}"> associados.apap.pt</a>

{{ config('app.name') }}
@endcomponent
