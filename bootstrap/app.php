<?php

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withSchedule(function (Schedule $schedule) {
        // we add this to run 
        $schedule->command('app:reset-quota-for-users')->dailyAt('00:00'); // reset quota for users
        $schedule->command('app:charge-subscriptions')->twiceDaily(1, 13); // charge subscriptions
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();