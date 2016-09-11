<?php namespace Propaganistas\LaravelIntl\Tests;

use Jenssegers\Date\Date as DateCore;
use Orchestra\Testbench\TestCase;
use Propaganistas\LaravelIntl\Facades\Date;
use Propaganistas\LaravelIntl\IntlServiceProvider;

class TestDate extends TestCase
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
        $this->assertEquals(DateCore::now(), carbon('now'));
        $this->assertEquals('Jenssegers\Date\Date', get_class(carbon()));
        $this->assertEquals(DateCore::parse('August 31'), carbon('August 31'));
    }

    public function testLocalesCanBeChanged()
    {
        $date = Date::setLocale('nl');
        $this->assertEquals('31 augustus', $date->parse('August 31')->format('j F'));

        $date::setFallbackLocale('fr');
        $date->setLocale('foo');
        $this->assertEquals('31 août', $date->parse('August 31')->format('j F'));

        $this->app->setLocale('nl');
        $this->assertEquals('31 augustus', carbon('August 31')->format('j F'));

        $this->app->setLocale('fr');
        $this->assertEquals('31 août', Date::parse('August 31')->format('j F'));
    }
}