<?php

namespace Dalholm\LaravelSettings\Cache;


abstract class DefaultCacheProfile implements CacheProfileInterface
{
    public function uniqueId(): string
    {
        return '';
    }

    public function prefix(): string
    {
        return config('laravel-settings.cache_prefix', 'laravel-settings');
    }

    public function tag(): string
    {
        $str = [
            $this->prefix(),
            $this->uniqueId(),
        ];

        return implode('-', $str);
    }

}