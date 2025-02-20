<?php

namespace Dalholm\LaravelSettings;

use Dalholm\LaravelSettings\Cache\CacheProfileInterface;
use Dalholm\LaravelSettings\Repositories\CacheRepository;
use Illuminate\Database\Connection;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;


class LaravelSettings
{
    /**
     * The Application
     *
     * @var \Illuminate\Foundation\Application
     */
    protected $container;

    /**
     * The database connection instance.
     *
     * @var \Illuminate\Database\Connection
     */
    protected $connection;

    /**
     * The table to query from.
     *
     * @var string
     */
    protected $table;

    /**
     * The key column name to query from.
     *
     * @var string
     */
    protected $key;

    /**
     * The value column name to query from.
     *
     * @var string
     */
    protected $value;

    /**
     * The value column name to query from.
     *
     * @var
     */
    protected $settings = [];

    public function __construct(
        protected CacheProfileInterface $cacheProfile,
        protected CacheRepository $cacheRepository,
    ) {
        $this->container = app();

        $this->connection = $this->container['db']->connection(config('setting.database.connection'));
        $this->table = $this->container['config']['laravel-settings.database.table'];
        $this->key = $this->container['config']['laravel-settings.database.key'];
        $this->value = $this->container['config']['laravel-settings.database.value'];

        $this->settings = $this->getSettings();
    }


    public function getSettings()
    {
        if ($this->cacheRepository->isEnabled()) {
            $cached = $this->cacheRepository->settings();
            if ($cached) {
                return $cached;
            }
        }

        $this->settings = $this->fallbacks();

        $settings = $this->newQuery()->get([$this->key, $this->value])->toArray();

        foreach ($settings as $index => $setting) {

            if (Arr::has($this->settings, $setting->key)) {

                Arr::set($this->settings, $setting->key, $setting->value);
                continue;
            }

            $this->settings = Arr::add($this->settings, $setting->key, $setting->value);
        }


        return $this->settings;
    }

    public function all()
    {
        return $this->settings;
    }


    public function get($val)
    {
        return Arr::get($this->settings, $val);

        return $this->cacheRepository->get($val);
    }

    public function set(array $array)
    {
        $array = Arr::dot($array);


        foreach ($array as $key => $value) {

            $existingValue = null;
            if (Arr::has($this->settings, $key)) {
                $existingValue = Arr::get($this->settings, $key);
            }

            /*
             * Manage fallback
             */
            if ($this->isFallback($key)) {

                if ($this->isEqualToFallback($key, $value)
                    && $existingValue == $value
                ) {
                    continue;
                }

                Arr::set($this->settings, $key, $value);

                $this->newQuery()->updateOrInsert(
                    ['key' => $key],
                    ['value' => $value]
                );

                // This item is handled, continue
                continue;
            }


            $this->newQuery()->updateOrInsert(
                ['key' => $key],
                ['value' => $value]
            );

            if (Arr::has($this->settings, $key)) {
                Arr::set($this->settings, $key, $value);
            } else {
                $this->settings = Arr::add($this->settings, $key, $value);
            }
        }

        if ($this->cacheRepository->isEnabled()) {
            $this->cacheRepository->put(Arr::dot($this->settings));
        }
    }

    public function isFallback($key)
    {
        return Arr::has($this->fallbacks(), $key);
    }

    public function fallbacks()
    {
        return Arr::dot($this->container['config']['laravel-settings.fallback']);
    }

    /**
     * Check if the given value is same as fallback.
     *
     * @param string $key
     * @param string $value
     *
     * @return bool
     */
    public function isEqualToFallback($key, $value)
    {
        return (string) Arr::get($this->fallbacks(), $key) == (string) $value;
    }


    protected function newQuery($insert = false)
    {
        return $this->connection->table($this->table);
    }
}
