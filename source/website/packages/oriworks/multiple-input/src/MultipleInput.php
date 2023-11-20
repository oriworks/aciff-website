<?php

namespace Oriworks\MultipleInput;

use Laravel\Nova\Fields\Field;

class MultipleInput extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'multiple-input';

    public function listBy($fieldName = 'value')
    {
        return $this->withMeta([
            'listBy' => $fieldName,
        ]);
    }
}
