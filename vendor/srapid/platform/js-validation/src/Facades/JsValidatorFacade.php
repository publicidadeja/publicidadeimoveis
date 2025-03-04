<?php

namespace Srapid\JsValidation\Facades;

use Illuminate\Support\Facades\Facade;

class JsValidatorFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'js-validator';
    }
}
