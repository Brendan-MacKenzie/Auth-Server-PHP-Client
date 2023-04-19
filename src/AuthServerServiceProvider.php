<?php

namespace BrendanMacKenzie\AuthServerClient;

use BrendanMacKenzie\AuthServerClient\Http\Middleware\AuthServerValidation;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;

class AuthServerServiceProvider extends ServiceProvider
{
  public function register()
  {
    $this->mergeConfigFrom(__DIR__.'/config/authserver.php', 'authserver');
  }

  public function boot(Kernel $kernel)
  {
    if ($this->app->runningInConsole()) {

        $this->publishes([
          __DIR__.'/config/authserver.php' => config_path('authserver.php'),
        ], 'config');

        $kernel->appendMiddlewareToGroup('web', AuthServerValidation::class);
        $kernel->appendMiddlewareToGroup('api', AuthServerValidation::class);
      }
  }
}