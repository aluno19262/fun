@component('mail::message')
# Dados de Pagamento de Inscrição na APAP

Caro(a) {{$associate->name}},<br>
A sua <a href="{{route('orders.show',[$associate->evaluation_order_id,'associate' => $associate->id])}}">inscrição na APAP</a> foi aprovada pela Direção.
@if(!empty($associate->evaluation_order_id))
    @if($associate->category == \App\Models\Associate::CATEGORY_ASSOCIADO_ESTUDANTE)
Para finalizar o processo, proceda ao pagamento da joia de inscrição: <br>
    @else
Para finalizar o processo, proceda ao pagamento da quota anual e da joia de inscrição: <br>
    @endif
Entidade: {{$associate->evaluationOrder->mb_ent}}<br>
Referência: {{$associate->evaluationOrder->mb_ref}}<br>
Total: {{$associate->evaluationOrder->total . '€'}}<br>
@endif
<br>
Em alternativa, poderá consultar o seu processo de inscrição e/ou dados para pagamento semestral na sua <a href="{{route('orders.show',[$associate->evaluation_order_id,'associate' => $associate->id])}}">área reservada</a>.<br>


Obrigado,<br>
{{ config('app.name') }}
@endcomponent
