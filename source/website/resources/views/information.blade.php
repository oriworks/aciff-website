<x-layout>
    <div class="container mx-auto p-3 grid grid-cols-3 gap-6">
        <article class="flex flex-col gap-4 text-content pb-2 text-with-margin col-span-2">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-semibold text-aciff">{{ $information->subject }}</h1>
                <div class="flex gap-2 items-center">
                    <span class="font-semibold text-aciff">{{ $information->publish_at->format('Y-m-d') }}</span>
                    @auth
                    <a href="/nova/resources/information/{{$information->id}}/edit" target="_blank"
                        class="bg-aciff rounded text-white no-underline p-2 hover:text-white">Editar</a>
                    @endauth
                </div>
            </div>
            {!! $information->content !!}
            <x-attachments :media="$information->getMedia('attachments')" />
            <div class="flex justify-between">
                <div class="flex flex-col justify-between">
                    <x-keywords :model="$information"/>
                </div>
                <div>
                    <x-share :entity="$entity" route="website.information" :model="$information"/>
                </div>
            </div>
        </article>
        <div class="flex flex-col gap-4">
            <h1 class="text-aciff uppercase">Pub:</h1>
            <div class="flex flex-wrap">
                @foreach ($banners as $banner)
                    <a href="{{$banner->link}}" class="w-1/2" alt="{{$banner->name}}">
                        <div class="aspect-w-16 aspect-h-9 bg-cover" style="background-image: url('{{ $banner->getFirstMediaUrl('banner') }}');"></div>
                    </a>
                @endforeach
            </div>
            <x-related :model="$information"/>
        </div>
    </div>
</x-layout>
