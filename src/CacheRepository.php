<?php

namespace Dalholm\LaravelSettings;

use Dalholm\LaravelSettings\Cache\CacheProfileInterface;
use Illuminate\Cache\Repository;
use Illuminate\Cache\TaggedCache;

class CacheRepository
{
    public function __construct(
        protected Repository $cache,
        protected CacheProfileInterface $cacheProfile
    )
    {

    }

    public function put(string $key, $value, \DateTime | int $seconds): void
    {
        $this->cache->tags([$this->cacheProfile->tag()])->put($key, $value, is_numeric($seconds) ? now()->addSeconds($seconds) : $seconds);
    }

    public function has(string $key): bool
    {
        return $this->cache->tags([$this->cacheProfile->tag()])->has($key);
    }

    public function get(string $key)
    {
        return $this->cache->tags([$this->cacheProfile->tag()])->get($key);
    }
}