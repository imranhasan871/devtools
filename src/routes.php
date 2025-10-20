<?php

use Illuminate\Support\Facades\Route;
use Imran\DevTools\Http\Controllers\DevController;

// Determine middleware: ensure 'devtools.allowed' is present for safety
$middleware = (array) config('devtools.middleware', ['web']);
if (!in_array('devtools.allowed', $middleware)) {
    // add after web if present, otherwise prepend
    $pos = array_search('web', $middleware, true);
    if ($pos !== false) {
        array_splice($middleware, $pos + 1, 0, ['devtools.allowed']);
    } else {
        array_unshift($middleware, 'devtools.allowed');
    }
}

Route::middleware($middleware)
    ->prefix('dev')
    ->name('dev.')
    ->group(function () {
        Route::get('/', [DevController::class, 'index'])->name('index');
        Route::get('clean', [DevController::class, 'clean'])->name('clean');
        Route::post('migrate', [DevController::class, 'migrate'])->name('migrate');
        Route::post('seed', [DevController::class, 'seed'])->name('seed');
    });
