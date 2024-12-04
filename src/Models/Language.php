<?php

namespace OzanKurt\LaravelIntl\Models;

use Illuminate\Support\Arr;
use OzanKurt\LaravelIntl\Contracts\Intl;
use OzanKurt\LaravelIntl\Concerns\WithLocales;
use OzanKurt\LaravelIntl\Exceptions\MissingLocaleException;

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
    public function get(string $key): ?string
    {
        return Arr::get($this->all(), $key, $key);
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
     * Load the data for the given locale.
     */
    protected function data(string $locale): array
    {
        if (! array_key_exists($locale, $this->data)) {
            $localePath = base_path("storage/locales/{$locale}/locale.php");

            if (! is_file($localePath)) {
                throw new MissingLocaleException($locale);
            }

            $this->data[$locale] = require $localePath;
        }

        return $this->data[$locale];
    }
}
