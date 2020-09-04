<?php

namespace Kurt\LaravelIntl;

use Kurt\LaravelIntl\Models\Number;
use Kurt\LaravelIntl\Models\Country;
use Kurt\LaravelIntl\Models\Currency;
use Kurt\LaravelIntl\Models\Language;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Events\LocaleUpdated;
use Kurt\LaravelIntl\Console\InstallLocaleCommand;

class IntlServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCountry();
        $this->registerCurrency();
        $this->registerLanguage();
        $this->registerNumber();
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['events']->listen(LocaleUpdated::class, function ($locale) {
            $this->setLocale($locale);
        });

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallLocaleCommand::class,
            ]);
        }
    }

    public function setLocale($locale)
    {
        $classes = [Country::class, Currency::class, Language::class, Number::class];

        foreach ($classes as $class) {
            app($class)->setLocale($locale);
        }
    }

    /**
     * Register the country repository.
     */
    protected function registerCountry(): void
    {
        $this->app->singleton(Country::class, function ($app) {
            $repository = new Country;

            return $repository->setLocale($app['config']['app.locale'])->setFallbackLocale($app['config']['app.fallback_locale']);
        });

        $this->app->alias(Country::class, 'intl.country');
    }

    /**
     * Register the currency repository.
     */
    protected function registerCurrency(): void
    {
        $this->app->singleton(Currency::class, function ($app) {
            $repository = new Currency;

            return $repository->setLocale($app['config']['app.locale'])->setFallbackLocale($app['config']['app.fallback_locale']);
        });

        $this->app->alias(Currency::class, 'intl.currency');
    }

    /**
     * Register the language repository.
     */
    protected function registerLanguage(): void
    {
        $this->app->singleton(Language::class, function ($app) {
            $repository = new Language;

            return $repository->setLocale($app['config']['app.locale'])->setFallbackLocale($app['config']['app.fallback_locale']);
        });

        $this->app->alias(Language::class, 'intl.language');
    }

    /**
     * Register the number repository.
     */
    protected function registerNumber(): void
    {
        $this->app->singleton(Number::class, function ($app) {
            $repository = new Number;

            return $repository->setLocale($app['config']['app.locale'])->setFallbackLocale($app['config']['app.fallback_locale']);
        });

        $this->app->alias(Number::class, 'intl.number');
    }
}
