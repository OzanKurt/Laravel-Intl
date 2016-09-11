<?php namespace Propaganistas\LaravelIntl\Facades;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Facade;

class Currency extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'intl.currency';
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

        // Reconfigure the locale every time the Facade is called.
        $instance->setLocale(App::getLocale());
        $instance->setFallbackLocale(Config::get('app.fallback_locale'));

        return $instance;
    }
}