<?php

namespace BrendanMacKenzie\AuthServerClient\Facades;

use Illuminate\Support\Facades\Facade;

class AuthServer extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'authserver';
    }
}