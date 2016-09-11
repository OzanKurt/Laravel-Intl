<?php namespace Propaganistas\LaravelIntl;

use CommerceGuys\Intl\Language\LanguageRepository;
use Propaganistas\LaravelIntl\Base\Intl;

class Language extends Intl
{
    /**
     * @var \CommerceGuys\Intl\Language\LanguageRepository
     */
    protected $data;

    /**
     * Language constructor.
     *
     * @param \CommerceGuys\Intl\Language\LanguageRepository $data
     */
    public function __construct(LanguageRepository $data)
    {
        $this->data = $data;
    }

    /**
     * Get the localized name for the specified language.
     *
     * @param string $langCode
     * @return string
     */
    public function name($langCode)
    {
        return $this->get($langCode)->getName();
    }
}