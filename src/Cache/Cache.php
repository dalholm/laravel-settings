<?php

namespace Dalholm\LaravelSettings\Cache;

use Cache;
use Dalholm\LaravelSettings\Exceptions\CacheNotEnabledException;
use Illuminate\Support\Collection;


class CacheRepository
{
    private bool $enabled;

    private ?string $store;

    private ?string $prefix;

    public function __construct(
        bool $enabled,
        ?string $store,
        ?string $prefix
    ) {
        $this->enabled = $enabled;
        $this->store = $store;
        $this->prefix = $prefix;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function has(string $settingsClass): bool
    {
        if ($this->enabled === false) {
            return false;
        }

        return Cache::store($this->store)->has($this->resolveCacheKey($settingsClass));
    }

    public function get(string $settingsClass): Settings
    {
        if ($this->enabled === false) {
            throw CacheNotEnabledException::throw();
        }

        return Cache::store($this->store)->get($this->resolveCacheKey($settingsClass));

    }

    public function put(Settings $settings): void
    {
        if ($this->enabled === false) {
            throw CacheNotEnabledException::throw();
        }

        $serialized = serialize($settings);

        Cache::store($this->store)->put(
            $this->resolveCacheKey(get_class($settings)),
            $serialized
        );
    }

    public function clear(): void
    {
        app(SettingsContainer::class)
            ->getSettingClasses()
            ->map(fn (string $class) => $this->resolveCacheKey($class))
            ->pipe(fn (Collection $keys) => Cache::store($this->store)->deleteMultiple($keys));
    }

    private function resolveCacheKey(string $settingsClass): string
    {
        $prefix = $this->prefix ? "{$this->prefix}." : '';

        return "{$prefix}settings.{$settingsClass}";
    }
}