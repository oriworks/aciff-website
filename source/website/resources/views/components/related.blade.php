@php
    if (isset($type) && $type === 'page') {
        $pagesRelated = $model->relatedPagesByTag()->inRandomOrder()->limit(4)->get();
        $informationRelated = $model->relatedInformationByTag()->inRandomOrder()->limit(4-$pagesRelated->count())->get();
    } else {
        $informationRelated = $model->relatedInformationByTag()->inRandomOrder()->limit(4)->get();
        $pagesRelated = $model->relatedPagesByTag()->inRandomOrder()->limit(4-$informationRelated->count())->get();
    }
@endphp
@foreach ($pagesRelated as $related)
    <x-related-item :related="$related" route="website.page" type="Page"/>
@endforeach
@foreach ($informationRelated as $related)
    <x-related-item :related="$related" route="website.information" type="Information"/>
@endforeach
