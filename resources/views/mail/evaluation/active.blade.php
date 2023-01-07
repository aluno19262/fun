@component('mail::message')
# Processo de Inscrição Concluído

Bem-vindo(a) à APAP,<br><br>
O seu processo de inscrição na Associação Portuguesa de Arquitectos Paisagistas foi concluído com sucesso.<br>
Poderá agora aceder à sua área reservada através do link <a href="associados.apap.pt">associados.apap.pt</a> e aceder à sua conta e aos serviços da APAP.<br>

Pode descarregar o recibo em:  <a href="{{$order->invoice_link}}">{{$order->invoice_link}}</a><br>
<br>
Também já está disponível a sua <a href="{{route('declarations.show',[$declaration,'associate_id' => $declaration->associate->id])}}">Declaração de Seguro de Responsabilidade Civil Profissional</a> na sua área reservada.<br>
Obrigado,<br>
{{ config('app.name') }}
@endcomponent
