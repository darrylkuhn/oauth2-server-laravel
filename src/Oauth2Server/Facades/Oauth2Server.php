<?php namespace Oauth2Server\Facades;

use Illuminate\Support\Facades\Facade;

class Oauth2Server extends Facade 
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'Oauth2Server'; }

}