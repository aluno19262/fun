@component('mail::message')
# Não foi possível emitir a fatura do pagamento do associado nº {{$associate->associate_number}} - {{$associate->name}} por falta de dados.

Para mais informações, pode <a href="{{route('orders.show',[$order,"associate_id" => $associate])}}">consultar o pagamento</a>.

{{ config('app.name') }}
@endcomponent
