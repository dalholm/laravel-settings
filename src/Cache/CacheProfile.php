<?php

namespace Dalholm\LaravelSettings\Cache;


class CacheProfile extends BaseCacheProfile
{
    public function prefix(): string
    {
        return '';
    }

}