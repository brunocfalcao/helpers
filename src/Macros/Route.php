<?php

namespace Brunocfalcao\Me\Macros;

use Illuminate\Support\Facades\Route;

Route::macro('name', function (): string {
    return $this->getCurrentRoute()->getName();
});
