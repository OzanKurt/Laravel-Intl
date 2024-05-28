<?php namespace Propaganistas\LaravelIntl\Interfaces;

interface IntlInterface
{
    /**
     * Get a localized entry.
     *
     * @param string $code
     * @return mixed
     */
    public function get($code);

    /**
     * Get a localized list of entries, keyed by their code.
     *
     * @return array
     */
    public function all();

    /**
     * Get the default locale.
     *
     * @return string
     */
    public function getLocale();

    /**
     * Set the default locale.
     *
     * @param $locale
     */
    public function setLocale($locale);

    /**
     * Get the fallback locale.
     *
     * @return string
     */
    public function getFallbackLocale();

    /**
     * Set the desired locale.
     *
     * @param $locale
     */
    public function setFallbackLocale($locale);
}