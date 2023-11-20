@if (($entity->twitter && $entity->twitter_share) || ($entity->facebook && $entity->facebook_share) || ($entity->linked_in && $entity->linked_in_share))
    <b>Partilhar:</b>
    <div class="flex gap-2">
        @if ($entity->twitter && $entity->twitter_share)
        <a class="text-twitter hover:text-black share_popup" target="_blank"
            href="https://twitter.com/intent/tweet?url={{ route($route, $model->slug) }}&text={{$model->subject}}&via={{$entity->twitter}}&hashtags={{$model->keywords->pluck('name')->implode(',')}}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 fill-current" viewBox="0 0 24 24">
                <path
                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-.139 9.237c.209 4.617-3.234 9.765-9.33 9.765-1.854 0-3.579-.543-5.032-1.475 1.742.205 3.48-.278 4.86-1.359-1.437-.027-2.649-.976-3.066-2.28.515.098 1.021.069 1.482-.056-1.579-.317-2.668-1.739-2.633-3.26.442.246.949.394 1.486.411-1.461-.977-1.875-2.907-1.016-4.383 1.619 1.986 4.038 3.293 6.766 3.43-.479-2.053 1.08-4.03 3.199-4.03.943 0 1.797.398 2.395 1.037.748-.147 1.451-.42 2.086-.796-.246.767-.766 1.41-1.443 1.816.664-.08 1.297-.256 1.885-.517-.439.656-.996 1.234-1.639 1.697z" />
            </svg>
        </a>
        @endif
        @if ($entity->facebook && $entity->facebook_share)
        <a class="text-facebook hover:text-black share_popup" target="_blank"
            href="http://www.facebook.com/sharer.php?u={{ route($route, $model->slug) }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 fill-current" viewBox="0 0 24 24">
                <path
                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-3 7h-1.924c-.615 0-1.076.252-1.076.889v1.111h3l-.238 3h-2.762v8h-3v-8h-2v-3h2v-1.923c0-2.022 1.064-3.077 3.461-3.077h2.539v3z" />
            </svg>
        </a>
        @endif
        @if ($entity->linked_in && $entity->linked_in_share)
        <a class="text-linkedIn hover:text-black share_popup" target="_blank"
            href="http://www.linkedin.com/shareArticle?mini=true&url={{ route($route, $model->slug) }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 fill-current" viewBox="0 0 24 24">
                <path
                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
            </svg>
        </a>
        @endif
    </div>
@endif
@push('meta')

<meta property="fb:app_id" content="981013972437601" />
<meta property="og:url" content="{{ route($route, $model->slug) }}" />
<meta property="og:type" content="article" />
<meta property="og:title" content="{{ $model->subject }}" />
<meta property="og:description" content="{{ $model->resume }}" />
<meta property="og:image" content="{{ $model->images ? $model->images[0] : asset('public/img/default_information_image.png') }}" />
@endpush
