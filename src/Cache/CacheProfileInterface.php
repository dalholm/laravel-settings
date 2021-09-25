<?php

namespace Dalholm\LaravelSettings\Cache;


interface CacheProfileInterface
{
    /*
     * Return a string to differentiate this request from others.
     *
     * For example: if you want a different cache per tenant or user you could return the id of the model
     *
     */

    public function prefix(): string;

    public function basePrefix(): string;

    public function cachePrefix(): string;
}