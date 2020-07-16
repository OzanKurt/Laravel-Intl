<?php

namespace Kurt\LaravelIntl\Tests;

use Orchestra\Testbench\TestCase;
use Kurt\LaravelIntl\Facades\Country;
use Kurt\LaravelIntl\IntlServiceProvider;

class TestCountry extends TestCase
{
    /**
     * @param \Illuminate\Foundation\Application $application
     * @return array
     */
    protected function getPackageProviders($application)
    {
        return [IntlServiceProvider::class];
    }

    public function setUp(): void
    {
        require_once __DIR__.'/../src/helpers.php';

        parent::setUp();
    }

    protected function getEnvironmentSetUp($app)
    {
        $app->setBasePath(__DIR__ . '/..');
        $app->setLocale('tr');
    }

    public function testHelper()
    {
        $this->assertEquals('Türkiye', country('TR'));
        $this->assertEquals('Kurt\LaravelIntl\Country', get_class(country()));
    }

    public function testHelperIsInSyncWithFacade()
    {
        Country::setLocale('tr');
        $this->assertEquals('tr', country()->getLocale());
    }

    public function testLocaleCanBeChanged()
    {
        $this->assertEquals('Türkiye', country('TR'));

        country()->setLocale('de');

        $this->assertEquals('Türkei', country('TR'));
    }

    public function testFallbackLocaleIsUsed()
    {
        country()->setLocale('de');

        $this->assertEquals('Germany', country('DE'));
    }

    public function testLocaleCanBeTemporarilyChanged()
    {
        $name = Country::usingLocale('de', function ($country) {
            return Country::name('TR');
        });

        $this->assertEquals('tr', Country::getLocale());
        $this->assertEquals('Türkei', $name);
    }

    public function testAll()
    {
        $countries = Country::all();
        $this->assertEquals('Türkiye', $countries['TR']);
        $this->assertEquals('Almanya', $countries['DE']); // Due to the fallback to `en`

        $countries = Country::setLocale('de')->all();
        $this->assertEquals('Türkei', $countries['TR']);
        $this->assertEquals('Germany', $countries['DE']); // Due to the fallback to `en`
    }

    public function testName()
    {
        $country = Country::name('TR');
        $this->assertEquals('Türkiye', $country);
    }
}
