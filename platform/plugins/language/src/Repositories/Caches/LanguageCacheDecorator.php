<?php

namespace Srapid\Language\Repositories\Caches;

use Srapid\Support\Repositories\Caches\CacheAbstractDecorator;
use Srapid\Language\Repositories\Interfaces\LanguageInterface;

class LanguageCacheDecorator extends CacheAbstractDecorator implements LanguageInterface
{
    /**
     * {@inheritDoc}
     */
    public function getActiveLanguage($select = ['*'])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getDefaultLanguage($select = ['*'])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
