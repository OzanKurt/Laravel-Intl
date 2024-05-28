<?php namespace Propaganistas\LaravelIntl\Base;

trait LocaleCallback
{
    /**
     * Temporarily use another locale for the given callback.
     *
     * @param string   $locale
     * @param callable $callback
     * @param string   $fallbackLocale
     * @return mixed
     */
    public function forLocale($locale, callable $callback, $fallbackLocale = '')
    {
        $original = $this->getLocale();
        $fallback = $this->getFallbackLocale();

        $this->setLocale($locale);
        $this->setFallbackLocale($fallbackLocale ?: $fallback);

        $result = $callback($this);

        $this->setLocale($original);
        $this->setFallbackLocale($fallback);

        return $result;
    }
}