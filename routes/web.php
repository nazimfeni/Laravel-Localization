<?php

use Illuminate\Support\Facades\App;
use App\Http\Middleware\Localization;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LocalizationController;

route::get('/localization/{locale}', LocalizationController::class)->name('localization');

route::middleware(Localization::class)
->group(function(){
                // Route::get('/', function () {
                //     return view('welcome');
                // });

                Route::view('/','welcome');

                Route::get('/dashboard', function () {
                    return view('dashboard');
                })->middleware(['auth', 'verified'])->name('dashboard');

                Route::middleware('auth')->group(function () {
                    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
                    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
                    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
                });


                require __DIR__.'/auth.php';
});



