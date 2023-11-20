<x-mail::message>
# {{ $subject }}

{!! $content !!}

@if($sender)
{!! nl2br($sender->signature) !!}
@endif

@isset($token)
<x-slot:subcopy>
@lang(
    'Se não desejar receber as nossas newsletter/comunicados [clique aqui](:cancelURL).',
    ['cancelURL' => route('newsletter.cancel', $token)]
)
</x-slot:subcopy>
@endisset

</x-mail::message>
