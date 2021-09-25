<?php

namespace Dalholm\LaravelSettings\Repositories;

use Dalholm\LaravelSettings\Cache\CacheProfileInterface;
use Dalholm\LaravelSettings\Exceptions\CacheNotEnabledException;
use Illuminate\Cache\Repository;
use Illuminate\Cache\TaggedCache;

class CacheRepository
{

    private bool $enabled;

    private string $store;


    public function __construct(
        protected Repository $cache,
        protected CacheProfileInterface $cacheProfile
    )
    {
        $this->enabled = config('laravel-settings.cache.enabled');
        $this->store = config('laravel-settings.cache.store') ?: 'redis';
    }


    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function settings()
    {
        if ($this->enabled === false) {
            throw CacheNotEnabledException::throw();
        }


        return $this->cache->get($this->resolveCacheKey('settings'));

    }

    public function put($value, $seconds = null): void
    {
        if ($this->enabled === false) {
            throw CacheNotEnabledException::throw();
        }

        if (!$seconds) {
            $seconds = 60 * 60 * 24;
        }

        $this->cache
            ->put($this->resolveCacheKey('settings'),
                $value,
                is_numeric($seconds) ? now()->addSeconds($seconds) : $seconds
            );

    }

    public function clear(): void
    {
        app(SettingsContainer::class)
            ->getSettingClasses()
            ->map(fn (string $class) => $this->resolveCacheKey($class))
            ->pipe(fn (Collection $keys) => Cache::store($this->store)->deleteMultiple($keys));
    }

    private function resolveCacheKey($key): String
    {
        return "{$this->cacheProfile->cachePrefix()}.{$key}";
    }
}