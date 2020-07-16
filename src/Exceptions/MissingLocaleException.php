<?php

namespace Kurt\LaravelIntl\Exceptions;

use Exception;

class MissingLocaleException extends Exception
{
    function __construct(string $locale)
    {
        parent::__construct("The locale [{$locale}] is not installed.");
    }
}
