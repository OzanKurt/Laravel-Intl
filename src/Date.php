<?php

namespace Propaganistas\LaravelIntl;

use Propaganistas\LaravelIntl\Concerns\WithLocales;
use Propaganistas\LaravelIntl\Contracts\Intl;
use Propaganistas\LaravelIntl\Proxies\Date as DateProxy;
use Punic\Data as FormatterData;

/**
 * @mixin \Jenssegers\Date\Date
 */
class Date extends Intl
{
    use WithLocales {
        setLocale as _setLocale;
        setFallbackLocale as _setFallbackLocale;
    }

    /**
     * Dynamically handle calls to the class.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return DateProxy::make()->{$method}(...$parameters);
    }

    /**
     * Set the current locale.
     *
     * @param string $locale
     * @return $this
     * @throws \Punic\Exception\InvalidLocale
     */
    public function setLocale($locale)
    {
        DateProxy::setLocale($locale);

        FormatterData::setDefaultLocale($locale);

        return $this->_setLocale($locale);
    }

    /**
     * Set the fallback locale.
     *
     * @param string $locale
     * @return $this
     * @throws \Punic\Exception\InvalidLocale
     */
    public function setFallbackLocale($locale)
    {
        DateProxy::setFallbackLocale($locale);

        FormatterData::setFallbackLocale($locale);

        return $this->_setFallbackLocale($locale);
    }
}