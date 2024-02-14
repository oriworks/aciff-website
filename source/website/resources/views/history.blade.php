<x-layout>
    @if (isset($page))
    <div class="container mx-auto p-3 grid grid-cols-3 gap-6">
        <x-history-menu :categories="$categories" />
        <div class="flex flex-col my-4 gap-4 text-content col-span-2">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-semibold text-aciff">História</h1>
                @auth
                <a href="/nova/resources/pages/{{$page->id}}/edit" target="_blank"
                    class="bg-aciff rounded text-white no-underline p-2 hover:text-white">Editar</a>
                @endauth
            </div>
            <div class="content">
                {!! $page->content !!}
            </div>
        </div>
    </div>
    @endif
</x-layout>
