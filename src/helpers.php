<?php

if (!function_exists('array_keys_exists')) {
    /**
     * Easily check if multiple array keys exist.
     *
     * @param array $keys
     * @param array $arr
     *
     * @return boolean
     */
    function array_keys_exists(array $keys, array $arr)
    {
        return !array_diff_key(array_flip($keys), $arr);
    }
}

if (!function_exists('settings')) {
    /**
     * Get / set the specified settings value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param array|string $key
     * @param mixed $default
     *
     * @return mixed
     */
    function settings($key = null, $default = null)
    {
        $settings = app('laravelsettings');

        if (is_null($key)) {
            return $settings;
        }

        if (is_array($key)) {
            $settings->set($key);

            return $settings;
        }

        return $settings->get($key, $default);
    }
}