<label class="{{ $full ? 'col-span-2' : '' }}">
    <span class="text-aciff">{{ $label }}:
        @if($required)
        <span class="text-red-500">*</span>
        @endif
    </span>
    <textarea
        class="mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0"
        name="{{ $name }}" rows="3">{{ old($name) }}</textarea>
    @error($name)
    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</label>
