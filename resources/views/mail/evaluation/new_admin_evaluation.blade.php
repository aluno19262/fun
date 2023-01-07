@component('mail::message')
# Candidatura Validada

Recebemos uma <a href="{{route('associates.evaluations',$associate)}}">nova inscrição</a> na APAP que já foi validada pela CAC.<br>
Aguarda agora aprovação da Direção.<br>
Em alternativa, poderá consultar através do link  <a href="{{route('associates.evaluations',$associate)}}">{{route('associates.evaluations',$associate)}}</a>.<br>
<br>
Obrigado,<br>
{{ config('app.name') }}
@endcomponent
