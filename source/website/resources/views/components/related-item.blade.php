{{-- <div class="flex-col gap-2">
    <a href="{{ route($route, $related->slug) }}">
        <h1 class="font-semibold text-aciff">{{ $related->subject }}</h1>
        @php $url = $related->images ? $related->images[0] : asset('img/default_information_image.png'); @endphp
        <div class="aspect-w-16 aspect-h-9 bg-cover" style="background-image: url('{{ $url }}');"></div>
    </a>
</div> --}}
<a href="{{ route($route, $related->slug) }}">
    <div class="flex flex-col rounded-lg shadow-lg overflow-hidden bg-white">
        <div class="flex-shrink-0">
            @php $url = $related->images ? $related->images[0] : asset('img/default_information_image.png'); @endphp
            <div class="aspect-w-2 aspect-h-1 bg-contain bg-no-repeat bg-center" style="background-image: url('{{ $url }}');"></div>
        </div>
        <div class="flex-1 bg-white pt-0 pb-6 px-6 flex flex-col justify-between">
            <div class="flex-1">
                <div class="flex justify-between">
                    <p class="text-sm font-medium">{{ isset($type) && $type === 'Page' ? 'Página' : 'Notícia' }}</p>
                    <p class="text-sm font-medium text-gray-500">{{ isset($related->publish_at) ? $related->publish_at->format('Y-m-d') : '' }}</p>
                </div>
                <p class="block mt-2 text-xl font-semibold text-aciff">{{ $related->subject }}</p>
            </div>
        </div>
    </div>
</a>
