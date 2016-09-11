<?php namespace Propaganistas\LaravelIntl\Facades;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Facade;

class Number extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'intl.number';
    }

    /**
     * Resolve the facade root instance from the container.
     *
     * @param  string|object  $name
     * @return mixed
     */
    protected static function resolveFacadeInstance($name)
    {
        $instance = parent::resolveFacadeInstance($name);

        $instance->setLocale(App::getLocale());
        $instance->setFallbackLocale(Config::get('app.fallback_locale'));

        return $instance;
    }
}