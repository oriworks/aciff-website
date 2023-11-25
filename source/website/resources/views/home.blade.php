<x-layout>
    <div class="flex aspect-w-16 aspect-h-4">
        <div class="slideShow">
            <div class="slideShowContainer">
                @foreach($gallery as $image)

                @php $url = $image->getFirstMediaUrl('gallery'); @endphp
                <div class="transition duration-500 absolute inset-0 opacity-0 bg-center bg-contain bg-no-repeat"
                    style="background-image: url({{$url}});">
                </div>
                @endforeach
            </div>
            <div class="slideShowControls container mx-auto relative h-full">
                <div class="slideShowIndicators flex absolute bottom-3 right-3 bg-gray-500 bg-opacity-50 rounded-2xl">
                </div>
            </div>
        </div>
    </div>
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-3">
        @foreach($news as $item)
        <div class="flex items-strech gap-4 text-content">
            <div class="w-2/3 text-sm text-aciff flex flex-col gap-2">
                <h1 class="font-semibold text-aciff">{{ $item->subject }}</h1>
                <div class="resume-information">
                    {!! $item->resume !!}
                </div>
                <div class="flex justify-between">
                    <b class="font-semibold text-aciff">{{ $item->publish_at->format('Y-m-d') }}</b>
                    <a href="{{ route('website.information', $item->slug) }}">clique para ler +</a>
                </div>
            </div>
            <div class="w-1/3">
                @php $url = $item->images ? $item->images[0] : asset('img/default_information_image.png');
                @endphp
                <div class="aspect-w-16 aspect-h-9 bg-cover" style="background-image: url('{{ $url }}');">
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-3">
        @foreach($banners as $banner)
        <a href="{{$banner->link}}" class="w-full" alt="{{$banner->name}}">
            <div class="aspect-w-16 aspect-h-9 bg-cover bg-no-repeat bg-center" style="background-image: url('{{ $banner->getFirstMediaUrl('banner') }}');"></div>
        </a>
        @endforeach
    </div>
</x-layout>
