@component('mail::message')
# Declaração de Seguro aguarda aprovação

Existe uma <a href="{{route('declarations.show',$declaration)}}">declaração de seguro</a> a aguardar aprovação da secretaria.<br>
@component('mail::button', ['url' => route('declarations.show',[$declaration,'associate' => $declaration->associate->id])])
    VER DECLARAÇÃO
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
