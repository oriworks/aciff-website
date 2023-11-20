<x-mail::message>

@foreach ($information as $info)
<x-mail::information :imageUrl="$info['image']">
# {{ $info['subject'] }}
{!! $info['content'] !!}
</x-mail::information>
@endforeach

<x-mail::table>
| @foreach ($banners as $banner) |@endforeach

| @foreach ($banners as $banner) - | @endforeach

| @foreach ($banners as $banner) ![{{$banner->name}}]({{$banner->getMedia('banner')[0]->getFullUrl()}}) |@endforeach
</x-mail::table>

@isset($token)
<x-slot:subcopy>
@lang(
    'Se não desejar receber as nossas newsletter/comunicados [clique aqui](:cancelURL).',
    ['cancelURL' => route('newsletter.cancel', $token)]
)
</x-slot:subcopy>
@endisset
</x-mail::message>
