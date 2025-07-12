<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsUser;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ProjectApiController;

use App\Http\Controllers\User\UserController;

Route::get('/', function () {
    return view('welcome');
});


////// Only for User Route 
Route::middleware(['auth',IsUser::class])->group(function(){

    Route::get('/dashboard', function () {
        return view('client.index');
    })->name('dashboard');

     Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');

});

////// End Only for User Route 

////// Only for Admin Route 
Route::prefix('admin')->middleware(['auth',IsAdmin::class])->group(function(){

   Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('admin.dashboard');

    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/password/update', [AdminController::class, 'AdminPasswordUpdate'])->name('admin.password.update');


  Route::controller(PlanController::class)->group(function(){
    Route::get('/all/plans', 'AllPlans')->name('all.plans');
    Route::get('/add/plans', 'AddPlans')->name('add.plans');
    Route::post('/store/plans', 'StorePlans')->name('store.plans');
    Route::get('/edit/plans/{id}', 'EditPlans')->name('edit.plans');
    Route::post('/update/plans', 'UpdatePlans')->name('update.plans');
    Route::get('/delete/plans/{id}', 'DeletePlans')->name('delete.plans');

  });

   Route::controller(ProjectController::class)->group(function(){
    Route::get('/all/projects', 'AllProjects')->name('all.projects');
    Route::get('/projects/create', 'CreateProject')->name('projects.create');
    Route::post('/projects/store', 'StoreProject')->name('projects.store');
    Route::get('/projects/edit/{project}', 'EditProject')->name('projects.edit');

  });




});

////// End Only for Admin Route 

  Route::post('api/projects/{project}/chat', [ProjectApiController::class, 'Chat'])->name('api.projects.chat');

  Route::get('api/projects/{project}/preview', [ProjectApiController::class, 'getPreview'])->name('api.projects.preview');


   Route::get('projects/{project}/preview', [ProjectController::class, 'ViewPreview'])->name('projects.preview');
   Route::get('projects/{project}/export', [ProjectController::class, 'Export'])->name('projects.export');












Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
