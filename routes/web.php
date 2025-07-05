<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsUser;

Route::get('/', function () {
    return view('welcome');
});


////// Only for User Route 
Route::middleware(['auth',IsUser::class])->group(function(){

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    

});

////// End Only for User Route 

////// Only for Admin Route 
Route::prefix('admin')->middleware(['auth',IsAdmin::class])->group(function(){

   Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('admin.dashboard');
    

});

////// End Only for Admin Route 














Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
