<?php

use Illuminate\Support\Facades\Auth;

/*
 * Creates a custom authenticate guard on-the-fly.
 *
 * @var string $guard
 * @var \Illuminate\Contracts\Auth\Authenticable $model
 */
Auth::macro('newGuard', function (string $guard, string $model, string $guardDriver = 'session', string $providerDriver = 'eloquent'): void {
    $guards = app('config')->get('auth.guards');

    app('config')->set('auth.guards', array_merge($guards, [
        $guard => [
            'driver' => $guardDriver,
            'provider' => "{$guard}-users",
        ],
    ]));

    $providers = app('config')->get('auth.providers');

    app('config')->set('auth.providers', array_merge($providers, [
        "{$guard}-users" => [
            'driver' => $providerDriver,
            'model' => $model,
        ],
    ]));
});
