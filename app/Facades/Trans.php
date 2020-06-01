<?php
/**
 * User: JohnAVu
 * Date: 2019-12-19
 * Time: 14:22
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Trans extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'trans';
    }
}