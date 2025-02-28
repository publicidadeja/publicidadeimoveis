<?php

namespace Srapid\Base\Forms\Fields;

use Assets;
use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Fields\FormField;

class TinyMceField extends FormField
{

    /**
     * {@inheritDoc}
     */
    protected function getTemplate()
    {
        Assets::addScriptsDirectly(config('core.base.general.editor.tinymce.js'))
            ->addScriptsDirectly('vendor/core/core/base/js/editor.js');

        return 'core/base::forms.fields.tinymce';
    }

    /**
     *{@inheritDoc}
     */
    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $options['class'] = Arr::get($options, 'class', '') . 'form-control editor-tinymce';
        $options['id'] = Arr::get($options, 'id', $this->getName());
        $options['rows'] = Arr::get($options, 'rows', 4);

        return parent::render($options, $showLabel, $showField, $showError);
    }
}
