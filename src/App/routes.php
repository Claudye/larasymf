<?php

use Simplecode\App\Controllers\LoginController;

return [
    /**
     * login route
     */
    addRoute(config('auth.login'),[LoginController::class,'login'])->name("login"),
    addRoute(config('auth.login'),[LoginController::class,'connect'])->setMethods(['POST']),
    addRoute(config('auth.logout'),[LoginController::class,'logout'])->setMethods(['POST'])->name('logout'),
    addRoute('/valid/input/{name}', ['validation','valid'])->setMethods(['POST']),
];