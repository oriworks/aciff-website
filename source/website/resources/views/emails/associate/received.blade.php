<x-mail::message>
# Ficha de sócio preenchida no site

Recebemos uma inscrição de sócio com os seguintes dados:

__Designação Social:__ {{$associate->social_designation}}<br />
__Morada:__<br>{!! nl2br($associate->address) !!}<br />
__Concelho:__ {{$associate->county}}<br />
__Freguesia:__ {{$associate->parish}}<br />
__Código Postal:__ {{$associate->zip_code}}<br />
__Localidade:__ {{$associate->locality}}<br />
__Contacto telf.:__ {{$associate->phone}}<br />
__Fax:__ {{$associate->fax}}<br />
__Site:__ {{$associate->website}}<br />
__Email:__ {{$associate->email}}<br />
__Nº id fiscal:__ {{$associate->nif}}<br />
__CAE:__ {{$associate->cae}}<br />
__Forma Jurídica:__ {{$associate->legal}}<br />
__Actividade:__ {{$associate->activity}}<br />
__Capital Social:__ {{$associate->joint_stock}}<br />
__Nº de Sócios:__ {{$associate->num_associates}}<br />
__Nº de Func.:__ {{$associate->num_employees}}<br />

__Pessoa a Contactar:__<br />
__Nome:__ {{$associate->contact_name}}<br />
__Cargo:__ {{$associate->contact_job}}<br />
__Contacto telf.:__ {{$associate->contact_phone}}<br />
__Email:__ {{$associate->contact_email}}<br />

__Pagamento de Quotas:__<br />
__Periodicidade:__ {{$associate->payment_periodicity}}<br />
__Tipo Pagam.:__ {{$associate->payment_type}}<br />

Por favor caso este assunto seja resolvido por si. Clique no botão abaixo.

<x-mail::button :url="route('associate.solved', [$associate->id, $token])">
Resolvido
</x-mail::button>

</x-mail::message>
