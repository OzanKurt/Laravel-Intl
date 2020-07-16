<?php

namespace Kurt\LaravelIntl\Models;

use Illuminate\Support\Arr;
use Kurt\LaravelIntl\Contracts\Intl;
use Kurt\LaravelIntl\Concerns\WithLocales;
use CommerceGuys\Intl\Currency\CurrencyRepository;
use CommerceGuys\Intl\Formatter\CurrencyFormatter;
use CommerceGuys\Intl\NumberFormat\NumberFormatRepository;

class Currency extends Intl
{
    use WithLocales;

    /**
     * Loaded localized currency data.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Array of localized currency formatters.
     *
     * @var array
     */
    protected $formatters = [];

    /**
     * Get a localized record by key.
     */
    public function get(string $currencyCode): string
    {
        return $this->data()->get($currencyCode)->getName();
    }

    /**
     * Alias of get().
     */
    public function name(string $currencyCode): string
    {
        return $this->get($currencyCode);
    }

    /**
     * Get the symbol of the given currency.
     */
    public function symbol(string $currencyCode): string
    {
        return $this->data()->get($currencyCode)->getSymbol();
    }

    /**
     * Format a number.
     *
     * @param string|int|float $number
     * @return mixed|string
     */
    public function format($number, string $currencyCode, array $options = [])
    {
        return $this->formatter()->format(
            $number,
            $currencyCode,
            $this->mergeOptions($options)
        );
    }

    /**
     * Format a number.
     *
     * @param string|int|float $number
     * @return mixed|string
     */
    public function formatAccounting($number, string $currencyCode, array $options = [])
    {
        return $this->formatter()->format(
            $number,
            $currencyCode,
            $this->mergeOptions($options, ['style' => 'accounting'])
        );
    }

    /**
     * Parse a localized currency string into a number.
     *
     * @param string $number
     * @return mixed|string
     */
    public function parse($number, string $currencyCode, array $options = [])
    {
        return $this->formatter()->parse(
            $number,
            $currencyCode,
            $this->mergeOptions($options)
        );
    }

    /**
     * Get all localized records.
     */
    public function all(): array
    {
        return $this->data()->getList();
    }

    /**
     * Get the formatter's key.
     */
    protected function getLocalesKey(string $locale, string $fallbackLocale): string
    {
        return implode('|', [
            $locale,
            $fallbackLocale,
        ]);
    }

    /**
     * The currency repository.
     */
    protected function data(): CurrencyRepository
    {
        $key = $this->getLocalesKey(
            $locale = $this->getLocale(),
            $fallbackLocale = $this->getFallbackLocale()
        );

        if (! isset($this->data[$key])) {
            $this->data[$key] = new CurrencyRepository($locale, $fallbackLocale);
        }

        return $this->data[$key];
    }

    /**
     * The current number formatter.
     */
    protected function formatter(): CurrencyFormatter
    {
        $key = $this->getLocalesKey(
            $locale = $this->getLocale(),
            $fallbackLocale = $this->getFallbackLocale()
        );

        if (! isset($this->formatters[$key])) {
            $this->formatters[$key] = new CurrencyFormatter(
                new NumberFormatRepository($fallbackLocale),
                $this->data(),
                ['locale' => $locale]
            );
        }

        return $this->formatters[$key];
    }

    /**
     * Merges the options array.
     */
    protected function mergeOptions(array $options, array $defaults = []): array
    {
        Arr::forget($options, 'locale');

        return $defaults + $options;
    }
}
