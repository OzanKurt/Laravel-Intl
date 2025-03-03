<?php

namespace OzanKurt\LaravelIntl\Contracts;

use Illuminate\Support\Traits\Macroable;

abstract class Intl
{
    use Macroable;

    /**
     * Get the current locale.
     *
     * @return string
     */
    abstract public function getLocale();

    /**
     * Set the current locale.
     *
     * @param $locale
     * @return $this
     */
    abstract public function setLocale($locale);

    /**
     * Get the fallback locale.
     *
     * @return string
     */
    abstract public function getFallbackLocale();

    /**
     * Set the fallback locale.
     *
     * @param $locale
     * @return $this
     */
    abstract public function setFallbackLocale($locale);

    /**
     * Run the given callable while using another locale.
     *
     * @param string $locale
     * @param string|callable $callback
     * @param string|null $fallbackLocale
     * @return mixed
     */
    public function usingLocale($locale, string|callable $callback, $fallbackLocale = null)
    {
        $originalLocale = $this->getLocale();
        $originalFallbackLocale = $this->getFallbackLocale();

        $this->setLocale($locale);
        $this->setFallbackLocale($fallbackLocale ?: $originalFallbackLocale);

        if (is_string($callback)) {
            $result = $this->get($callback);
        } else {
            $result = $callback($this);
        }

        $this->setFallbackLocale($originalFallbackLocale);
        $this->setLocale($originalLocale);

        return $result;
    }
}
