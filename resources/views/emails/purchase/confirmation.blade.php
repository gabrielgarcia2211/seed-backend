@component('mail::message')
# ¡Gracias por tu compra, {{ $user->name }}!

Este es un mensaje de confirmación enviado a: **{{ $user->email }}**

Estamos procesando tu pedido.

Gracias,<br>
{{ config('app.name') }}
@endcomponent