<x-layout>
    <div class="container mx-auto grid grid-cols-2 gap-6 p-3">
        <div class="col-span-2">
            <h1 class="text-2xl font-semibold text-aciff">Notícias</h1>
        </div>
        @foreach($list as $information)
        <div class="flex items-strech gap-4 text-content">
            <div class="w-2/3 text-sm text-aciff flex flex-col gap-2">
                <h1 class="font-semibold text-aciff">{{ $information->subject }}</h1>
                <div class="resume-information">
                    {!! $information->resume !!}
                </div>
                <div class="flex justify-between">
                    <b class="font-semibold text-aciff">{{ $information->publish_at->format('Y-m-d') }}</b>
                    <a href="{{ route('website.information', $information->slug) }}">clique para ler +</a>
                </div>
            </div>
            <div class="w-1/3">
                @php $url = $information->images ? $information->images[0] : asset('img/default_information_image.png');
                @endphp
                <div class="aspect-w-16 aspect-h-9 bg-cover" style="background-image: url('{{ $url }}');">
                </div>
            </div>
        </div>
        @endforeach
        <div class="col-span-2">
            {{ $list->onEachSide(2)->links() }}
        </div>
    </div>
</x-layout>
