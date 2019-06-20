<?php

namespace Tele2Api\Facades;

use Illuminate\Support\Facades\Facade;
use Tele2Api\Services\Tele2Api;

class Tele2 extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Tele2Api::class;
    }
}
