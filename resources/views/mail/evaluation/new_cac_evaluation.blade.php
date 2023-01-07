@component('mail::message')
# Nova Candidatura

Recebemos uma <a href="{{route('associates.evaluations',$associate)}}">nova inscrição</a> na APAP que aguarda validação da CAC.<br>
Em alternativa, poderá consultar através do link <a href="{{route('associates.evaluations',$associate)}}">{{route('associates.evaluations',$associate)}}</a>.

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
