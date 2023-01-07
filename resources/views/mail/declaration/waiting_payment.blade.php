@component('mail::message')
# {{!empty($declaration) ? $declaration->declarationTemplate->name : ""}}

Na sequência da submissão do seu pedido de {{!empty($declaration->declarationTemplate) ? $declaration->declarationTemplate->name : ""}} com a referência {{!empty($declaration->declaration_number)}}, deve efetuar o pagamento para avançar com o processo.<br>
Entidade : {{$order->mb_ent}}<br>
Referência : {{$order->mb_ref}}<br>
Total : {{$order->total .'€'}}<br>

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
