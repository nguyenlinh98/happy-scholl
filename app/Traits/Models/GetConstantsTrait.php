<?php

namespace App\Traits\Models;

use ReflectionClass;

trait GetConstantsTrait
{
    public function getPredefinedConstants($prepend = '')
    {
        $reflectionClass = new ReflectionClass($this);
        if ('' === $prepend) {
            return $reflectionClass->getConstants();
        }

        return array_filter($reflectionClass->getConstants(), function ($item) use ($prepend) { return 0 === strpos($item, $prepend); }, ARRAY_FILTER_USE_KEY);
    }
}
