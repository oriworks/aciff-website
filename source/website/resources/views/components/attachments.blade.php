@if ($media->count() > 0)
    <div>
        <h4 class="font-semibold text-aciff">Anexos:</h4>
        <hr>
        @foreach($media as $attachment)
        <a href="{{$attachment->getFullUrl()}}" target="_blank">{{
            ($attachment->getCustomProperty('description') ?
            $attachment->getCustomProperty('description') : $attachment->name . '.' .
            $attachment->getTypeAttribute()) }}</a>
        @endforeach
    </div>
@endif
