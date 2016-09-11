<?php namespace Propaganistas\LaravelIntl;

use CommerceGuys\Intl\Formatter\NumberFormatter;
use CommerceGuys\Intl\NumberFormat\NumberFormatRepository;
use Propaganistas\LaravelIntl\Base\Intl;

class Number extends Intl
{
    /**
     * @var \CommerceGuys\Intl\NumberFormat\NumberFormatRepository
     */
    protected $data;

    /**
     * Number constructor.
     *
     * @param \CommerceGuys\Intl\NumberFormat\NumberFormatRepository $data
     */
    public function __construct(NumberFormatRepository $data)
    {
        $this->data = $data;
    }

    /**
     * Format an value in the given locale (or app locale if not specified).
     *
     * @param int|float $value
     * @return string
     */
    public function format($value)
    {
        $format = $this->get();
        $formatter = new NumberFormatter($format);

        return $formatter->format($value);
    }

    /**
     * Format an value as percents in the given locale (or app locale if not specified).
     *
     * @param int|float $value
     * @return string
     */
    public function percent($value)
    {
        $format = $this->get();
        $formatter = new NumberFormatter($format, NumberFormatter::PERCENT);

        return $formatter->format($value);
    }

    /**
     * Get a localized entry.
     *
     * @param string|null $code
     * @return mixed
     */
    public function get($code = null)
    {
        return $this->data->get(null);
    }

    /**
     * Get a localized list of entries, keyed by their code.
     *
     * @return array
     */
    public function all()
    {
        // Unsupported.
        return [];
    }
}