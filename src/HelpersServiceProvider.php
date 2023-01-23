<?php

namespace Brunocfalcao\Helpers;

use Brunocfalcao\Helpers\Commands\ClearCacheCommand;
use Brunocfalcao\Helpers\Commands\ClearLogCommand;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use ImLiam\BladeHelper\Facades\BladeHelper;

final class HelpersServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerMacros();
        $this->bootBladeDirectives();

        $this->commands([
            ClearLogCommand::class,
            ClearCacheCommand::class,
        ]);
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

    protected function bootBladeDirectives()
    {
        /*
         * Renders only if the current route action name is equal to
         * the specified one.
         * E.g: @action('create')  @endaction
         */
        Blade::if(
            'action',
            function ($action) {
                if (Route::getCurrentRoute()->getActionMethod() == $action) {
                    return $action;
                }
            }
        );

        /*
         * Renders only if the current route name is equal to the specified.
         * E.g: @routename('welcome')  @routename
         */
        Blade::if(
            'routename',
            function ($routeName) {
                if (Route::getCurrentRoute()->getName() == $routeName) {
                    return $routeName;
                }
            }
        );

        /*
         * @image_placeholder_url($width, $height = null, $text = null, $backgroundColor = null)
         */
        BladeHelper::directive(
            'image_placeholder_url',
            function ($width, $height = null, $text = null, $background = null) {
                return "https://via.placeholder.com/{$width}x{$height}/{$background}?text={$text}";
            }
        );

        /*
         * @htmlentities('Bruno Falcão') ==> Bruno Falc&#227;o
         */
        BladeHelper::directive(
            'htmlentities',
            function ($value) {
                return htmlentities($value);
            }
        );

        BladeHelper::directive(
            'url',
            function ($value) {
                return url($value);
            }
        );
    }

    public function register()
    {
        //
    }
}
