<?php

namespace App\Services\Slack\Facades;

use Illuminate\Support\Facades\Facade;

class Slack extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \App\Services\Slack\Slack::class;
    }
}
