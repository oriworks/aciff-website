<x-layout>
    <div class="container mx-auto p-3 grid grid-cols-3 gap-6">
        <x-history-menu :categories="$categories" />
        <div class="flex flex-col my-4 gap-4 col-span-2">
            <div class="flex items-center gap-2 text-content">
                @if (isset($category->parent))
                    <a href="/historia/{{$category->parent->slug}}" class="text-2xl font-semibold text-aciff">{{ $category->parent->name}}</a>
                    <span class="text-2xl font-semibold text-aciff">/</span>
                @endif
                <h1 class="text-2xl font-semibold text-aciff">{{ $category->name }}</h1>
            </div>
            <div>
                @if ($documents->count() > 0)
                    <div class="flex flex-col gap-4">
                        @foreach ($documents as $document)
                            <div class="grid grid-cols-4 gap-4">
                                <img class="w-full" src="{{ Storage::url($document->pages[1]) }}">
                                <div class="col-span-3 flex flex-col gap-4">
                                    <h2 class="text-xl font-semibold text-aciff">{{ $document->subject }}</h2>
                                    <p>{!! $document->content !!}</p>
                                    <div class="flex gap-4">
                                        <portal :document="{{ $document }}"></portal>
                                        @if ($document->downloadable)
                                            <a href="/historia/documentos/{{$document->id}}/download" class="flex gap-2 items-center rounded bg-gray-600 px-2 py-1 text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600 no-underline">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                                </svg>
                                                <span>Descarregar</span>
                                            </a>
                                        @endif
                                        @if ($document->requestable)
                                            <request-form>
                                                <x-request-form></x-request-form>
                                            </request-form>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-span-4">
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ $documents->onEachSide(2)->links() }}
                @else
                    <p>Nenhum documento encontrado nesta categoria.</p>
                @endif

            </div>
        </div>
    </div>
</x-layout>
