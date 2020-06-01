<?php

if (!function_exists('getConstant')) {

    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    function getConstant($key, $default = null)
    {
        return config('constant.' . $key, $default);
    }
}
