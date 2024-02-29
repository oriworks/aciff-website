<div class="bg-gray-100 shadow-md sticky top-0 z-10">
    <div class="container mx-auto flex justify-between px-3">
        <a href="/" class="py-3">
            <img src="{{$entity->getFirstMediaUrl('logo')}}" alt="[{{ $entity->name }}]" class="h-12">
        </a>
        <div class="inline-flex xl:hidden py-3">
            <button id="toggle-side-menu" aria-controls="mobile-menu" aria-expanded="false"
                class="items-center justify-center p-2 rounded-md text-gray-500 hover:text-white hover:bg-gray-500 focus:outline-none focus:ring-0 focus:ring-inset focus:ring-gray-500">
                <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
        <div class="hidden xl:inline-flex">
            @foreach ($menu as $item)
            @if($item->child()->count() == 0)
            <a href="{{ $item->page ? route('website.page', $item->page->slug) : $item->link }}" target="{{ $item->link ? '_blank' : '' }}"
                class="flex items-center p-2 cursor-pointer whitespace-nowrap text-gray-500 hover:bg-gray-300">
                {{ Str::of($item->name)->upper() }}
            </a>
            @else
            <div
                class="group flex items-center p-2 cursor-pointer whitespace-nowrap text-gray-500 hover:bg-gray-300 relative">
                {{ Str::of($item->name)->upper() }}
                <div class="hidden group-hover:block absolute bg-gray-100 shadow-md top-full right-0">
                    @foreach ($item->child as $child)
                    @if ($child->page ? $child->page->slug : $child->link)
                    <a href="{{ $child->page ? route('website.page', $child->page->slug) : $child->link }}"
                        target="{{ $child->link ? '_blank' : '' }}"
                        class="block p-3 cursor-pointer whitespace-nowrap hover:bg-gray-300">
                        {{ Str::of($child->name)->upper() }}
                    </a>

                    @else
                    <span class="block p-3 whitespace-nowrap hover:bg-gray-300">
                        {{ Str::of($child->name)->upper() }}
                    </span>

                    @endif
                    @if($child->child()->count() > 0)
                    @foreach ($child->child as $subitem)
                    <a href="{{ $subitem->page ? route('website.page', $subitem->page->slug) : $subitem->link }}"
                        target="{{ $subitem->link ? '_blank' : '' }}"
                        class="block p-11 py-3 cursor-pointer whitespace-nowrap hover:bg-gray-300">
                        {{ Str::of($subitem->name)->upper() }}
                    </a>
                    @endforeach
                    @endif
                    @endforeach
                </div>
            </div>
            @endif
            @endforeach
            @auth
            <a href="{{ route('nova.login') }}"
                class="flex items-center p-2 cursor-pointer whitespace-nowrap text-gray-500 hover:bg-gray-300">
                {{ Str::of('Back office')->upper() }}
            </a>
            <form method="post" action="/nova/logout" class="flex items-center p-2 cursor-pointer whitespace-nowrap text-gray-500 hover:bg-gray-300">
                @csrf
                <input type="submit" name="submit" value="{{ Str::of('Log out')->upper() }}">
            </form>
            @endauth
        </div>
    </div>
</div>
