<?php

namespace Propaganistas\LaravelIntl\Contracts;

abstract class Intl
{
    /**
     * Store previously used keywords in memory.
     * 
     * @var array
     */
    protected static $searchCache = [];
    
    /**
     * Get the current locale.
     *
     * @return string
     */
    abstract public function getLocale();

    /**
     * Set the current locale.
     *
     * @param $locale
     * @return $this
     */
    abstract public function setLocale($locale);

    /**
     * Get the fallback locale.
     *
     * @return string
     */
    abstract public function getFallbackLocale();

    /**
     * Set the fallback locale.
     *
     * @param $locale
     * @return $this
     */
    abstract public function setFallbackLocale($locale);

    /**
     * Get the search cache.
     * 
     * @return array
     */
    public function getSearchCache()
    {
        return static::$searchCache;
    }

    /**
     * Forget the search cache as whole or by key.
     *
     * @return array
     */
    public function forgetSearchCache($cacheKey = null)
    {
        if ($cacheKey) {
            unset(static::$searchCache[$cacheKey]);
        } else {
            static::$searchCache = [];
        }

        return $this;
    }

    /**
     * Search the data by the given keywords.
     * 
     * @param  array|string $keywords
     * @return array
     */
    public function search($keywords) {
        [$keywords, $excludeKeywords, $includeKeywords] = $this->parseKeywords($keywords);

        $cacheKey = md5(json_encode($keywords));

        if (array_key_exists($cacheKey, static::$searchCache)) {
            return static::$searchCache[$cacheKey];
        }

        $results = $this->all();

        $filterCallback = function ($name) use ($includeKeywords, $excludeKeywords) {
            $includeCondition = $excludeCondition = true;

            if (! empty($includeKeywords)) {
                $includeCondition = preg_match('/'.implode('|', $includeKeywords).'/', $name);
            }

            if (! empty($excludeKeywords)) {
                $excludeCondition = !preg_match('/'.implode('|', $excludeKeywords).'/', $name);
            }

            return $includeCondition && $excludeCondition;
        };

        $results = array_filter($results, $filterCallback);

        return static::$searchCache[$cacheKey] = $results;
    }
    
    /**
     * Parse the given keywords into include/exclude keywords.
     *
     * @param  array|string $keywords
     * @return array
     */
    protected function parseKeywords($keywords)
    {
        if (is_string($keywords)) {
            $keywords = explode('|', $keywords);
        }

        $excludeKeywords = $includeKeywords = [];

        foreach ($keywords as $keyword) {
            if (Str::startsWith($keyword, ['-', '\\-'])) {
                $excludeKeywords[] = str_replace(['-', '\\'], '', $keyword);
            }  else {
                $includeKeywords[] = $keyword;
            }
        }

        return [$keywords, $excludeKeywords, $includeKeywords];
    }

    /**
     * Run the given callable while using another locale.
     *
     * @param string $locale
     * @param callable $callback
     * @param string|null $fallbackLocale
     * @return mixed
     */
    public function usingLocale($locale, callable $callback, $fallbackLocale = null)
    {
        $originalLocale = $this->getLocale();
        $originalFallbackLocale = $this->getFallbackLocale();

        $this->setLocale($locale);
        $this->setFallbackLocale($fallbackLocale ?: $originalFallbackLocale);

        $result = $callback($this);

        $this->setFallbackLocale($originalFallbackLocale);
        $this->setLocale($originalLocale);

        return $result;
    }
}
