<label class="{{ isset($full) && $full ? 'col-span-2' : '' }}">
    <span class="text-aciff">{{ $label }}:
        @if($required)
        <span class="text-red-500">*</span>
        @endif
    </span>
    <select
        class="block w-full mt-1 rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0"
        name="{{ $name }}">
        @if($options->count() > 1)<option>Selecione uma opção</option>@endif
        @foreach($options as $option)
            @if (old($name) === $option["value"])
                <option value='{{ $option["value"] }}' selected>{{ $option["name"] }}</option>
            @else
                <option value='{{ $option["value"] }}'>{{ $option["name"] }}</option>
            @endif
        @endforeach
    </select>
    @error($name)
    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</label>
