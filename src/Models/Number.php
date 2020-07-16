<?php

namespace Kurt\LaravelIntl\Models;

use Illuminate\Support\Arr;
use Kurt\LaravelIntl\Contracts\Intl;
use Kurt\LaravelIntl\Concerns\WithLocales;
use CommerceGuys\Intl\Formatter\NumberFormatter;
use CommerceGuys\Intl\NumberFormat\NumberFormatRepository;

class Number extends Intl
{
    use WithLocales;

    /**
     * Array of localized number formatters.
     *
     * @var array
     */
    protected $formatters = [];

    /**
     * Format a number.
     *
     * @param string|int|float $number
     * @param array $options
     * @return string
     */
    public function format($number, array $options = []): string
    {
        return $this->formatter()->format(
            $number,
            $this->mergeOptions($options)
        );
    }

    /**
     * Format as percentage.
     *
     * @param string|int|float $number
     */
    public function percent($number, array $options = []): string
    {
        return $this->formatter()->format(
            $number,
            $this->mergeOptions($options, ['style' => 'percent'])
        );
    }

    /**
     * Parse a localized number into native PHP format.
     *
     * @param string|int|float $number
     * @param array $options
     * @return string|false
     */
    public function parse($number, array $options = [])
    {
        return $this->formatter()->parse(
            $number,
            $this->mergeOptions($options)
        );
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
     * The current number formatter.
     */
    protected function formatter(): NumberFormatter
    {
        $key = $this->getLocalesKey(
            $locale = $this->getLocale(),
            $fallbackLocale = $this->getFallbackLocale()
        );

        if (! isset($this->formatters[$key])) {
            $this->formatters[$key] = new NumberFormatter(new NumberFormatRepository($fallbackLocale), ['locale' => $locale]);
        }

        return $this->formatters[$key];
    }

    /**
     * Merges the options array.
     *
     * @param array $options
     * @param array $defaults
     * @return array
     */
    protected function mergeOptions(array $options, array $defaults = []): array
    {
        Arr::forget($options, 'locale');

        return $defaults + $options;
    }
}
