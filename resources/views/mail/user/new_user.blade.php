@component('mail::message')
# Caro(a) {{$user->name}},

Bem-vindo(a) à nova plataforma para os associados da Associação Portuguesa dos Arquitectos Paisagistas.

A partir de agora poderá aceder à sua área reservada em <a href="{{route('home')}}">associados.apap.pt</a> com os seus dados de acesso:<br>
E-mail: {{$user->email}}<br>
Password: {{$password}}<br>

Através da sua área reservada poderá gerir as suas quotas, solicitar declarações e manter os seus dados actualizados.

Se tiver alguma dúvida, não hesite em contactar-nos através do <a href="{{route('contacts.create')}}">Centro de Ajuda</a> ou dos canais habituais.

Com os melhores cumprimentos,<br>
{{ config('app.name') }}
@endcomponent
