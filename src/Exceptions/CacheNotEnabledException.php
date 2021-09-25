<?php

namespace Dalholm\LaravelSettings\Exceptions;

use Exception;

class CacheNotEnabledException extends Exception
{
    public static function throw(): self
    {
        return new self('Laravel settings cache not enabled');
    }
}