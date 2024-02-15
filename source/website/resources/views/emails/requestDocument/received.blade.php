<x-mail::message>
# Pedido de documento recebido através do formulário do site

Recebemos um contacto com o seguintes dados:

__Nome:__ {{$requestDocument->name}}<br />
__Contacto telf.:__ {{$requestDocument->phone}}<br />
__Email:__ {{$requestDocument->email}}<br />
__Documento:__ {{$requestDocument->document->subject}}<br />
**Mensagem:**<br />{!! nl2br($requestDocument->content) !!}

Por favor caso este assunto seja resolvido por si. Clique no botão abaixo.

<x-mail::button :url="route('requestDocument.solved', [$requestDocument->id, $token])">
Resolvido
</x-mail::button>

</x-mail::message>
