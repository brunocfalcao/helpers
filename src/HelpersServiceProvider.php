<?php

namespace Brunocfalcao\Helpers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class HelpersServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        // MySQL? Load the default string length to 191 chars.
        if (config('database.connections.'.config('database.default').'.driver') == 'mysql') {
            Schema::defaultStringLength(191);
        }

        $this->registerMacros();
    }

    private function registerMacros()
    {
        // Include all files from the Macros folder.
        Collection::make(glob(__DIR__.'/Macros/*.php'))
                  ->mapWithKeys(function ($path) {
                      return [$path => pathinfo($path, PATHINFO_FILENAME)];
                  })
                  ->each(function ($macro, $path) {
                      require_once $path;
                  });
    }

    public function register()
    {
    }
}
