<?php namespace Propaganistas\LaravelIntl\Tests;

use Orchestra\Testbench\TestCase;
use Propaganistas\LaravelIntl\Facades\Number;
use Propaganistas\LaravelIntl\IntlServiceProvider;

class TestNumber extends TestCase
{
    public function getPackageProviders($app)
    {
        return [IntlServiceProvider::class];
    }

    public function setUp()
    {
        require_once __DIR__ . '/../src/helpers.php';

        parent::setUp();
    }

    public function testHelper()
    {
        $this->assertEquals('1,234', number(1234));
        $this->assertEquals('Propaganistas\LaravelIntl\Number', get_class(number()));
    }

    public function testHelperIsInSyncWithFacade()
    {
        Number::setLocale('foo');
        $this->assertEquals('foo', number()->getLocale());
    }

    public function testLocaleCanBeChanged()
    {
        $this->app->setLocale('nl');
        $this->assertEquals('1.234', Number::format(1234));

        Number::setLocale('en');
        $this->assertEquals('1,234', Number::format(1234));
    }

    public function testFallbackLocaleIsUsed()
    {
        Number::setLocale('foo');
        Number::setFallbackLocale('fr');
        $this->assertEquals('1 234', Number::format(1234));
    }

    public function testLocaleCanBeTemporarilyChanged()
    {
        $this->app->setLocale('nl');
        $number = Number::forLocale('en', function($country) {
            return Number::format(1234);
        });

        $this->assertEquals('nl', Number::getLocale());
        $this->assertEquals('1,234', $number);
    }

    public function testGet()
    {
        $number = Number::get();
        $this->assertEquals('CommerceGuys\Intl\NumberFormat\NumberFormat', get_class($number));
        $this->assertEquals('%', $number->getPercentSign());
    }

    public function testAll()
    {
        $number = Number::all();
        $this->assertEmpty($number);
    }

    public function testFormat()
    {
        $number = Number::format(1234);
        $this->assertEquals('1,234', $number);
    }

    public function testPercent()
    {
        $number = Number::percent(75);
        $this->assertEquals('75%', $number);
    }

    public function testParse()
    {
        $this->app->setLocale('nl');
        $number = Number::parse('1,2');
        $this->assertEquals(1.2, $number);
    }
}