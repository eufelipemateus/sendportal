<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Helper extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'sendportal.helper';
    }
}
