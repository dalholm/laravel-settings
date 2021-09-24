<?php

namespace Dalholm\LaravelSettings\Cache;


class CacheProfile extends DefaultCacheProfile
{
    public function uniqueId() : string
    {
        return '';
    }

}