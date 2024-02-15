<x-mail::message>
# Pedido de documento enviado através do formulário do site

Recebemos o seu contacto com o seguintes dados:

__Nome:__ {{$requestDocument->name}}<br />
__Contacto telf.:__ {{$requestDocument->phone}}<br />
__Email:__ {{$requestDocument->email}}<br />
__Documento:__ {{$requestDocument->document->subject}}<br />
**Mensagem:**<br />{!! nl2br($requestDocument->content) !!}

Aguarde o nosso contacto. Tentaremos ser breves.

Com cumprimentos,<br>
Da equipa de História

</x-mail::message>
