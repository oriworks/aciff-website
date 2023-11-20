@if ($model->keywords->count() > 0)
    <b>Palavras chave:</b>
    <div class="flex flex-wrap gap-2">
        @foreach($model->keywords as $keyword)
        <span class="bg-aciff text-white rounded-full px-4">{{ $keyword->name }}</span>
        @endforeach
    </div>
@endif
