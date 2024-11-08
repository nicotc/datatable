<?php

namespace Nicotc\Datatable\Facades;

use Illuminate\Support\Facades\Facade;

class Datatable extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'datatable';
    }
}
