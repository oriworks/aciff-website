<x-mail::message>
# Contacto recebido através do formulário do site

Recebemos um contacto com o seguintes dados:

__Nome:__ {{$suggestion->name}}<br />
__Contacto telf.:__ {{$suggestion->phone}}<br />
__Email:__ {{$suggestion->email}}<br />
__Assunto:__ {{$suggestion->subject}}<br />
**Mensagem:**<br />{!! nl2br($suggestion->content) !!}

Por favor caso este assunto seja resolvido por si. Clique no botão abaixo.

<x-mail::button :url="route('suggestion.solved', [$suggestion->id, $token])">
Resolvido
</x-mail::button>

</x-mail::message>
