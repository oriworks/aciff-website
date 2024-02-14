<div class="flex flex-col my-4">
    @foreach ($categories as $category)
        <a href="/historia/{{$category->slug}}" alt="{{$category->name}}" class="p-2 text-aciff hover:text-black hover:bg-gray-200">
            {{$category->name}}
        </a>
        @if ($category->child()->count() > 0)
            @foreach ($category->child as $subitem)
            <a href="/historia/{{$subitem->slug}}" alt="{{$subitem->name}}" class="p-2 px-6 text-aciff hover:text-black hover:bg-gray-200">
                {{$subitem->name}}
            </a>
            @endforeach
        @endif
    @endforeach
</div>
