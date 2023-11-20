<x-mail::message>

@if(isset($link))
    [![$subject]({{$image}})]({{$link}})
@else
    ![$subject]({{$image}})
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
