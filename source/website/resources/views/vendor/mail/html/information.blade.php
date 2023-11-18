@props(['imageUrl'])
<div style="display: flex;">
<div style="flex-grow: 1;">
{{ Illuminate\Mail\Markdown::parse($slot) }}
</div>
<div>
<img src="{{ $imageUrl }}" />
</div>
<span style="display: block; clear: both; margin-bottom: 20px;"></span>
</div>
