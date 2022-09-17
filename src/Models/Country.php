<?php

namespace Kurt\LaravelIntl\Models;

use Illuminate\Support\Arr;
use Kurt\LaravelIntl\Contracts\Intl;
use Kurt\LaravelIntl\Concerns\WithLocales;
use Kurt\LaravelIntl\Exceptions\MissingLocaleException;

class Country extends Intl
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
    public function get(string $key): ?string
    {
        return Arr::get($this->all(), $key);
    }

    /**
     * Alias of get().
     */
    public function name(string $key): ?string
    {
        return $this->get($key);
    }

    /**
     * Get all localized records.
     */
    public function all(): array
    {
        $default = $this->data($this->getLocale());
        $fallback = $this->data($this->getFallbackLocale());

        return $default + $fallback;
    }

    /**
     * Get the data for the given locale.
     */
    protected function data(string $locale): array
    {
        if (! array_key_exists($locale, $this->data)) {
            $localePath = base_path("storage/locales/{$locale}/country.php");

            if (! is_file($localePath)) {
                throw new MissingLocaleException($locale);
            }

            $this->data[$locale] = require $localePath;
        }

        return $this->data[$locale];
    }
}
