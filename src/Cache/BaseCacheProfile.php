<?php

namespace Dalholm\LaravelSettings\Cache;


abstract class BaseCacheProfile implements CacheProfileInterface
{
    public function basePrefix(): String
    {
        return 'laravel-settings';
    }

    public function cachePrefix(): String
    {
        $str = $this->basePrefix();

        if ($this->prefix() != '') {

            $str = $str . '-' . $this->prefix();
        }

        return $str;
    }


}