<?php

namespace Dalholm\LaravelSettings;

use Dalholm\LaravelSettings\Cache\CacheProfileInterface;
use Illuminate\Database\Connection;
use Illuminate\Http\Request;


class LaravelSettings
{

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

    public function __construct(
        protected CacheProfileInterface $cacheProfile,
    ) {
        $this->container = app();

        $this->connection = $this->container['db']->connection(config('setting.database.connection'));
        $this->table = $this->container['config']['laravel-settings.database.table'];
        $this->key = $this->container['config']['laravel-settings.database.key'];
        $this->value = $this->container['config']['laravel-settings.database.value'];
    }

    public function get($val)
    {

        dd($this->cacheProfile->tag());
        dd($this->newQuery());
        dd(\DB::connection()->getDatabaseName());
        dd($val);
    }


    public function fallbacks($key, $default = null)
    {
        if (($default !== null) || is_array($key)) {
            return $default;
        }

        return Arr::get((array) $this->container['config']['laravel-settings.fallback'], $key);
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
        return (string) $this->fallbacks($key) == (string) $value;
    }


    protected function newQuery($insert = false)
    {
        return $this->connection->table($this->table);
    }
}
