<div id="side-menu"
    class="flex flex-shrink-0 absolute z-20 sm:relative xl:hidden bg-gray-600 h-full w-0 transition-all duration-500 ease-in-out overflow-x-hidden overflow-y-auto">
    <ul class="flex flex-col flex-grow text-gray-100">
        @foreach ($menu as $item)
        @if($item->child()->count() == 0)
        <a href="{{ $item->page ? route('website.page', $item->page->slug) : $item->link }}"
            target="{{ $item->link ? '_blank' : '' }}"
            class="block p-3 cursor-pointer whitespace-nowrap border-r-4 border-gray-600 hover:bg-gray-800 hover:border-blue-700">
            {{ Str::of($item->name)->upper() }}
        </a>
        @else
        <div class="block flex-shrink-0 overflow-hidden transition-all duration-500 ease-in-out h-12">
            <p class="flex justify-between p-3 cursor-default text-gray-400" id="toggle-menu">{{
                Str::of($item->name)->upper() }}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-all transform -rotate-90" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </p>
            @foreach ($item->child as $child)
            @if ($child->page ? $child->page->slug : $child->link)
            <a href="{{ $child->page ? route('website.page', $child->page->slug) : $child->link }}"
                target="{{ $child->link ? '_blank' : '' }}"
                class="block p-11 py-3 cursor-pointer whitespace-nowrap border-r-4 border-gray-600 hover:bg-gray-800 hover:border-blue-700">
                {{ $child->name }}
            </a>
            @else
            <span
                class="block p-11 py-3 cursor-default whitespace-nowrap border-r-4 border-gray-600 hover:bg-gray-800 hover:border-blue-700">
                {{ $child->name }}
            </span>
            @endif
            @if($child->child()->count() > 0)
            @foreach ($child->child as $subitem)
            <a href="{{ $subitem->page ? route('website.page', $subitem->page->slug) : $subitem->link }}"
                target="{{ $subitem->link ? '_blank' : '' }}"
                class="block p-16 py-3 cursor-pointer whitespace-nowrap border-r-4 border-gray-600 hover:bg-gray-800 hover:border-blue-700">
                {{ $subitem->name }}
            </a>
            @endforeach
            @endif
            @endforeach
        </div>
        @endif
        @endforeach
        @auth
        <a href="{{ route('nova.login') }}"
            class="block p-3 cursor-pointer whitespace-nowrap border-r-4 border-gray-600 hover:bg-gray-800 hover:border-blue-700">
            {{ Str::of('Back office')->upper() }}
        </a>
        <form method="post" action="/nova/logout" class="block p-3 cursor-pointer whitespace-nowrap border-r-4 border-gray-600 hover:bg-gray-800 hover:border-blue-700">
            @csrf
            <input type="submit" name="submit" value="{{ Str::of('Log out')->upper() }}">
        </form>
        @endauth
    </ul>
</div>
