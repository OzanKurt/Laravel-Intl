<?php

namespace Kurt\LaravelIntl\Models;

use Illuminate\Support\Arr;
use Kurt\LaravelIntl\Contracts\Intl;
use Kurt\LaravelIntl\Concerns\WithLocales;
use Kurt\LaravelIntl\Exceptions\MissingLocaleException;

class Language extends Intl
{
    use WithLocales;

    /**
     * Loaded localized country data.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Get a localized record by key.
     */
    public function get(string $key, $locale = null): string
    {
        return Arr::get($this->all($locale), $key, $key);
    }

    /**
     * Alias of get().
     */
    public function name(string $key, $locale = null): string
    {
        return $this->get($key, $locale);
    }

    /**
     * Get all localized records.
     */
    public function all($locale = null): array
    {
        $default = $this->data($locale ?? $this->getLocale());
        $fallback = $this->data($this->getFallbackLocale());

        return $default + $fallback;
    }

    /**
     * Load the data for the given locale.
     */
    protected function data(string $locale): array
    {
        if (! array_key_exists($locale, $this->data)) {
            $localePath = base_path("storage/locales/{$locale}/locale.php");

            if (! is_file($localePath)) {
                throw new MissingLocaleException($locale);
            }

            $this->data[$locale] = require_once $localePath;
        }

        return $this->data[$locale];
    }
}
