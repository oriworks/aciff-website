<x-mail::message>
# Contacto enviado através do formulário do site

Recebemos o seu contacto com o seguintes dados:

__Nome:__ {{$suggestion->name}}<br />
__Contacto telf.:__ {{$suggestion->phone}}<br />
__Email:__ {{$suggestion->email}}<br />
__Assunto:__ {{$suggestion->subject}}<br />
**Mensagem:**<br />{!! nl2br($suggestion->content) !!}

Aguarde o nosso contacto. Tentaremos ser breves.

Com cumprimentos,<br>
Da equipa ACIFF

</x-mail::message>
