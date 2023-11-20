<x-layout>
    @if (isset($page))
    <div class="container mx-auto p-3 flex flex-col gap-4 text-content">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-aciff">{{ $page->subject }}</h1>
            @auth
            <a href="/nova/resources/pages/{{$page->id}}/edit" target="_blank"
                class="bg-aciff rounded text-white no-underline p-2 hover:text-white">Editar</a>
            @endauth
        </div>
        {!! $page->content !!}

        <div class="w-9/12 mx-auto">
            <div class="grid grid-flow-row grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($departments as $department)
                    <div class="{{ $loop->index === 0 ? 'row-span-3' : '' }}">
                        <h1 class="font-semibold italic text-aciff">{{$department->name}}</h1>
                        @if ($department->address) <p class="flex gap-2"><b>Morada:</b>{{$department->address}}</p> @endif
                        @if ($department->zip_code) <p class="flex gap-2"><b>Codigo Postal:</b>{{$department->zip_code}}</p> @endif
                        @if ($department->phone) <p class="flex gap-2"><b>Telf:</b><a href="tel:{{$department->phone}}">{{$department->phone}}</a></p> @endif
                        @if ($department->fax) <p class="flex gap-2"><b>Fax:</b>{{$department->fax}}</p> @endif
                        @if ($department->emails)
                            <p class="flex gap-2"><b>Email:</b>
                                <span>
                                    @foreach($department->emails as $contact)
                                    <a href="mailto:{{ $contact->email }}">{{$contact->email}}</a>
                                    @endforeach
                                </span>
                            </p>
                        @endif
                        @if ($department->website) <p class="flex gap-2"><b>Site:</b><a href="http://{{$department->website}}">{{$department->website}}</a></p> @endif
                    </div>
                @endforeach
            </div>
        </div>
        <x-contact-form :departments="$departments" />
    </div>
    @endif
</x-layout>
