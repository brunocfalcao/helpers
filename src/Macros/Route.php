<?php

use Illuminate\Support\Facades\Route;

/*
 * Shortcut for the route name.
 */
Route::macro('name', function () {
    return $this->getCurrentRoute()->getName();
});
