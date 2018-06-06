<?php namespace Propaganistas\LaravelIntl\Tests;

use Carbon\Carbon;
use Orchestra\Testbench\TestCase;
use Propaganistas\LaravelIntl\Date as DateCore;
use Propaganistas\LaravelIntl\Facades\Date;
use Propaganistas\LaravelIntl\IntlServiceProvider;
use Propaganistas\LaravelIntl\Proxies\Date as DateProxy;

class TestDate extends TestCase
{
    /**
     * @param \Illuminate\Foundation\Application $application
     * @return array
     */
    protected function getPackageProviders($application)
    {
        return [IntlServiceProvider::class];
    }

    public function setUp()
    {
        require_once __DIR__.'/../src/helpers.php';

        parent::setUp();
    }

    public function testHelper()
    {
        $this->assertEquals((string) Carbon::now(), (string) carbon('now'));
        $this->assertEquals(DateCore::class, get_class(carbon()));
        $this->assertEquals(Carbon::parse('August 31'), carbon('August 31'));
    }

    public function testHelperIsInSyncWithFacade()
    {
        Date::setLocale('fr');
        $this->assertEquals('fr', carbon()->getLocale());
    }

    public function testLocaleCanBeChanged()
    {
        $this->app->setLocale('nl');
        $this->assertEquals('31 augustus', Date::parse('August 31')->format('j F'));

        Date::setLocale('en');
        $this->assertEquals('31 August', Date::parse('August 31')->format('j F'));
    }

    public function testFallbackLocaleIsUsed()
    {
        Date::setFallbackLocale('fr');
        Date::setLocale('foo');
        $this->assertEquals('31 août', Date::parse('August 31')->format('j F'));
    }

    public function testLocaleCanBeTemporarilyChanged()
    {
        $this->app->setLocale('nl');
        $date = Date::usingLocale('en', function($currency) {
            return Date::parse('August 31')->format('j F');
        });

        $this->assertEquals('nl', Date::getLocale());
        $this->assertEquals('31 August', $date);
    }

    public function testStaticCallsAreForwarded()
    {
        $this->assertEquals(DateProxy::class, get_class(Date::create(2018,1,1)));
        $this->assertEquals(DateProxy::class, get_class(carbon()->parse('August 31')));
    }

    public function testToShortDateString()
    {
        $this->app->setLocale('nl');
        $date = Date::create(2018,1,31)->toShortDateString();

        $this->assertEquals('31-01-18', $date);
    }

    public function testToMediumDateString()
    {
        $this->app->setLocale('nl');
        $date = Date::create(2018,1,31)->toMediumDateString();

        $this->assertEquals('31 jan. 2018', $date);
    }

    public function testToLongDateString()
    {
        $this->app->setLocale('nl');
        $date = Date::create(2018,1,31)->toLongDateString();

        $this->assertEquals('31 januari 2018', $date);
    }

    public function testToFullDateString()
    {
        $this->app->setLocale('nl');
        $date = Date::create(2018,1,31)->toFullDateString();

        $this->assertEquals('woensdag 31 januari 2018', $date);
    }

    public function testToShortTimeString()
    {
        $this->app->setLocale('nl');
        $date = Date::create(2018,1,31,1,2,3)->toShortTimeString();

        $this->assertEquals('01:02', $date);
    }

    public function testToMediumTimeString()
    {
        $this->app->setLocale('nl');
        $date = Date::create(2018,1,31,1,2,3)->toMediumTimeString();

        $this->assertEquals('01:02:03', $date);
    }

    public function testToLongTimeString()
    {
        $this->app->setLocale('nl');
        $date = Date::create(2018,1,31,1,2,3)->toLongTimeString();

        $this->assertEquals('01:02:03 GMT+0', $date);
    }

    public function testToFullTimeString()
    {
        $this->app->setLocale('nl');
        $date = Date::create(2018,1,1,1,2,3)->toFullTimeString();

        $this->assertEquals('01:02:03 GMT+00:00', $date);
    }

    public function testToShortDatetimeString()
    {
        $this->app->setLocale('nl');
        $date = Date::create(2018,1,31,1,2,3)->toShortDatetimeString();

        $this->assertEquals('31-01-18 01:02', $date);
    }

    public function testToMediumDatetimeString()
    {
        $this->app->setLocale('nl');
        $date = Date::create(2018,1,31,1,2,3)->toMediumDatetimeString();

        $this->assertEquals('31 jan. 2018 01:02:03', $date);
    }

    public function testToLongDatetimeString()
    {
        $this->app->setLocale('nl');
        $date = Date::create(2018,1,31,1,2,3)->toLongDatetimeString();

        $this->assertEquals('31 januari 2018 om 01:02:03 GMT+0', $date);
    }

    public function testToFullDatetimeString()
    {
        $this->app->setLocale('nl');
        $date = Date::create(2018,1,31,1,2,3)->toFullDatetimeString();

        $this->assertEquals('woensdag 31 januari 2018 om 01:02:03 GMT+00:00', $date);
    }

    public function testGetShortDateFormat()
    {
        $this->app->setLocale('nl');
        $date = Date::getShortDateFormat();

        $this->assertEquals('dd-MM-yy', $date);
    }

    public function testGetMediumDateFormat()
    {
        $this->app->setLocale('nl');
        $date = Date::getMediumDateFormat();

        $this->assertEquals('d MMM y', $date);
    }

    public function testGetLongDateFormat()
    {
        $this->app->setLocale('nl');
        $date = Date::getLongDateFormat();

        $this->assertEquals('d MMMM y', $date);
    }

    public function testGetFullDateFormat()
    {
        $this->app->setLocale('nl');
        $date = Date::getFullDateFormat();

        $this->assertEquals('EEEE d MMMM y', $date);
    }

    public function testGetShortTimeFormat()
    {
        $this->app->setLocale('nl');
        $date = Date::getShortTimeFormat();

        $this->assertEquals('HH:mm', $date);
    }

    public function testGetMediumTimeFormat()
    {
        $this->app->setLocale('nl');
        $date = Date::getMediumTimeFormat();

        $this->assertEquals('HH:mm:ss', $date);
    }

    public function testGetLongTimeFormat()
    {
        $this->app->setLocale('nl');
        $date = Date::getLongTimeFormat();

        $this->assertEquals('HH:mm:ss z', $date);
    }

    public function testGetFullTimeFormat()
    {
        $this->app->setLocale('nl');
        $date = Date::getFullTimeFormat();

        $this->assertEquals('HH:mm:ss zzzz', $date);
    }

    public function testGetShortDatetimeFormat()
    {
        $this->app->setLocale('nl');
        $date = Date::getShortDatetimeFormat();

        $this->assertEquals('dd-MM-yy HH:mm', $date);
    }

    public function testGetMediumDatetimeFormat()
    {
        $this->app->setLocale('nl');
        $date = Date::getMediumDatetimeFormat();

        $this->assertEquals('d MMM y HH:mm:ss', $date);
    }

    public function testGetLongDatetimeFormat()
    {
        $this->app->setLocale('nl');
        $date = Date::getLongDatetimeFormat();

        $this->assertEquals('d MMMM y \'om\' HH:mm:ss z', $date);
    }

    public function testGetFullDatetimeFormat()
    {
        $this->app->setLocale('nl');
        $date = Date::getFullDatetimeFormat();

        $this->assertEquals('EEEE d MMMM y \'om\' HH:mm:ss zzzz', $date);
    }
}
