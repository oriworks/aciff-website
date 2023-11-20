<label class="{{ isset($full) && $full ? 'col-span-2' : '' }}">
    @if(isset($label) && $label)
    <span class="text-aciff">{{ $label }}:
        @if($required)
        <span class="text-red-500">*</span>
        @endif
    </span>
    @endif
    <input type="{{ (isset($type) && $type) ? $type : 'text' }}"
        class="block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0"
        name="{{ $name }}" value="{{ old($name) }}"
        placeholder="{{ isset($placeholder) && $placeholder ? $placeholder : '' }}">
    @error($name)
    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</label>
