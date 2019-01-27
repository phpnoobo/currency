<?php

namespace Phpnoob\Currency\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Currency
 * @package Phpnoob\Currency\Facades
 */
class Currency extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'currency';
    }
}
