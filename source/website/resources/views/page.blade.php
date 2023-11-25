<x-layout>
    @if (isset($page))
    <div class="container mx-auto p-3 grid grid-cols-3 gap-6">
        <div class="flex flex-col my-4 gap-4 text-content col-span-2">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-semibold text-aciff">{{ $page->subject }}</h1>
                @auth
                <a href="/nova/resources/pages/{{$page->id}}/edit" target="_blank"
                    class="bg-aciff rounded text-white no-underline p-2 hover:text-white">Editar</a>
                @endauth
            </div>
            <div class="content">
                {!! $page->content !!}
            </div>
            <x-attachments :media="$page->getMedia('page_attachments')" />
            <div class="flex justify-between">
                <div class="flex flex-col justify-between">
                    <x-keywords :model="$page" />
                </div>
                <div>
                    <x-share :entity="$entity" route="website.page" :model="$page" />
                </div>
            </div>
            @if (isset($page->department))
            @php
            $departments = collect([$page->department]);
            @endphp
            <div class="flex justify-between">
                <x-contact-form :departments="$departments" />
            </div>
            @endif
        </div>
        <div class="flex flex-col gap-4">
            <h1 class="text-aciff uppercase">Pub:</h1>
            <div class="flex flex-wrap">
                @foreach ($banners as $banner)
                <a href="{{$banner->link}}" class="w-1/2" alt="{{$banner->name}}">
                    <div class="aspect-w-16 aspect-h-9 bg-cover"
                        style="background-image: url('{{ $banner->getFirstMediaUrl('banner') }}')"></div>
                </a>
                @endforeach
            </div>
            <x-related :model="$page" type="page" />
        </div>
    </div>
    @endif
</x-layout>
