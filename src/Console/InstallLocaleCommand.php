<?php

namespace Kurt\LaravelIntl\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class InstallLocaleCommand extends Command
{
    protected $signature = 'laravel-intl:install-locale {locale}';

    protected $description = 'Install a new locale';

    protected $locale;

    protected $resources = [
        'country' => [
            'name' => 'Country List',
            'url' => 'https://raw.githubusercontent.com/umpirsky/country-list/master/data/%LOCALE%/country.php',
        ],
        'locale' => [
            'name' => 'Locale List',
            'url' => 'https://raw.githubusercontent.com/umpirsky/locale-list/master/data/%LOCALE%/locales.php',
        ],
    ];

    public function handle()
    {
        $this->locale = $this->argument('locale');

        $baseDirectoryPath = $this->getBaseDirectoryPath();

        if (! File::isDirectory($baseDirectoryPath)) {
            File::makeDirectory($baseDirectoryPath);
        }

        foreach ($this->resources as $key => $resource) {
            $this->installSource($key, $resource);
        }
    }

    protected function installSource($key, $resource)
    {
        $response = Http::get($this->updateSourceWithLocale($resource['url']));

        if ($response->failed()) {
            $this->error("{$resource['name']} for [{$this->locale}] could not be downloaded.");
            return;
        }

        $directoryPath = $this->getDirectoryPath();

        if (! File::isDirectory($directoryPath)) {
            File::makeDirectory($directoryPath);
        }

        $filePath = $this->getFilePath($key);

        File::put($filePath, $response->body());

        $this->info("{$filePath} for [{$this->locale}] has been successfully installed.");
    }

    protected function updateSourceWithLocale($source)
    {
        return str_replace('%LOCALE%', $this->locale, $source);
    }

    protected function getBaseDirectoryPath()
    {
        return storage_path("locales");
    }

    protected function getDirectoryPath()
    {
        return storage_path("locales/{$this->locale}");
    }

    protected function getFilePath($key)
    {
        return storage_path("locales/{$this->locale}/{$key}.php");
    }
}
