<?php namespace Propaganistas\LaravelIntl\Base;

use Propaganistas\LaravelIntl\Interfaces\IntlInterface;

class Intl implements IntlInterface
{
    use LocaleCallback;

    /**
     * @var mixed
     */
    protected $data;

    /**
     * Get a localized entry.
     *
     * @param string $code
     * @return mixed
     */
    public function get($code)
    {
        return $this->data->get($code);
    }

    /**
     * Get a localized list of entries, keyed by their code.
     *
     * @return array
     */
    public function all()
    {
        return $this->data->getList();
    }

    /**
     * Get the default locale.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->data->getDefaultLocale();
    }

    /**
     * Set the default locale.
     *
     * @param string $locale
     * @return $this
     */
    public function setLocale($locale)
    {
        $this->data->setDefaultLocale($locale);

        return $this;
    }

    /**
     * Get the fallback locale.
     *
     * @return string
     */
    public function getFallbackLocale()
    {
        return $this->data->getFallbackLocale();
    }

    /**
     * Set the desired locale.
     *
     * @param string $locale
     * @return $this
     */
    public function setFallbackLocale($locale)
    {
        $this->data->setFallbackLocale($locale);

        return $this;
    }
}