<?php

namespace Kurt\LaravelIntl\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallLocaleCommand extends Command
{
    protected $name = 'laravel-intl:install-locale {locale}';

    protected $description = 'Install a new locale';

    protected $locale;

    public function handle()
    {
        $this->locale = $this->argument($locale);

        $this->downloadCountryList();
    }

    protected function downloadCountryList()
    {
        $baseUrl = 'https://raw.githubusercontent.com/umpirsky/country-list/master/data/%LOCALE%/locales.php';

        $url = str_replace('%LOCALE%', $this->locale, $baseUrl);

        $response = Http::get($url);

        if ($response->failed()) {
            $this->error("Country List for locale [{$this->locale}] could not be downloaded.");
            return;
        }

        File::put(storage_path("locales/{$this->locale}/country.php"), $response->body());
    }

    protected function downloadLocaleList()
    {
        $baseUrl = 'https://raw.githubusercontent.com/umpirsky/locale-list/master/data/%LOCALE%/locales.php';

        $url = str_replace('%LOCALE%', $this->locale, $baseUrl);

        if ($response->failed()) {
            $this->error("Locale List for locale [{$this->locale}] could not be downloaded.");
            return;
        }

        File::put(storage_path("locales/{$this->locale}/locales.php"), $response->body());
    }
}
