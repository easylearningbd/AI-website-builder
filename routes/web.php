<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsUser;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ProjectApiController;
use App\Http\Controllers\Admin\BlogController;

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserProjectController;

use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\ReviewController;

Route::get('/', function () {
    return view('home.index');
});


////// Only for User Route 
Route::middleware(['auth',IsUser::class])->group(function(){

    Route::get('/dashboard', function () {
        return view('client.index');
    })->name('dashboard');

     Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
     Route::get('/user/profile', [UserController::class, 'UserProfile'])->name('user.profile');
     Route::post('/user/profile/store', [UserController::class, 'UserProfileStore'])->name('user.profile.store');

     Route::get('/user/change/password', [UserController::class, 'UserChangePassword'])->name('user.change.password');
     Route::post('/user/password/update', [UserController::class, 'UserPasswordUpdate'])->name('user.password.update');


 Route::controller(UserController::class)->group(function(){
    Route::get('/plans/upgrade', 'PlanUpgrade')->name('plans.upgrade');
    Route::get('/plans/subscribe/{planId}', 'PlanSubscribe')->name('plans.subscribe');

    Route::get('/plans/payment/{transactionId}', 'showPaymentForm')->name('plans.payment'); 
    
    Route::post('/plans/payment/{transactionId}', 'ProcessPayment')->name('plans.processPayment'); 

  });


  Route::controller(UserProjectController::class)->group(function(){
    Route::get('/user/all/projects', 'UserAllProjects')->name('user.all.projects'); 
    Route::get('/user/projects/create', 'UserProjectsCreate')->name('user.projects.create'); 
    Route::post('/user/projects/store', 'UserProjectsStore')->name('user.projects.store');

    Route::get('/user/projects/edit/{project}', 'UserProjectsEdit')->name('user.projects.edit');

  });




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

  Route::controller(ProjectController::class)->group(function(){
    Route::get('/all/orders', 'AllOrders')->name('all.orders');
    Route::patch('/update/transaction/{id}', 'UpdateTransaction')->name('update.transaction'); 

  });

  Route::controller(BlogController::class)->group(function(){
    Route::get('/all/blog', 'AllBlog')->name('all.blog');
    Route::get('/add/blog', 'AddBlog')->name('add.blog');

  });


    Route::controller(HomeController::class)->group(function(){
    Route::get('/get/slider', 'GetSlider')->name('get.slider'); 
    Route::post('/update/slider', 'UpdateSlider')->name('update.slider'); 

  });

  Route::controller(ReviewController::class)->group(function(){
    Route::get('/all/review', 'AllReview')->name('all.review');   
    Route::get('/add/review', 'AddReview')->name('add.review');
    Route::post('/store/review', 'StoreReview')->name('store.review');

  });




});

////// End Only for Admin Route 

  Route::post('api/projects/{project}/chat', [ProjectApiController::class, 'Chat'])->name('api.projects.chat');

  Route::get('api/projects/{project}/preview', [ProjectApiController::class, 'getPreview'])->name('api.projects.preview');


   Route::get('projects/{project}/preview', [ProjectController::class, 'ViewPreview'])->name('projects.preview');
   Route::get('projects/{project}/export', [ProjectController::class, 'Export'])->name('projects.export');


 //////////// BLOG ALL ROUTE 
   Route::get('/generate-blog/{title}', [BlogController::class, 'GenerateBlog'])->name('generate.blog');

   Route::post('/save-blog', [BlogController::class, 'SaveBlog'])->name('save.blog');
   Route::get('/edit/blog/{id}', [BlogController::class, 'EditBlog'])->name('edit.blog');

   Route::post('/update/blog', [BlogController::class, 'UpdateBlog'])->name('update.blog');
   Route::get('/delete/blog/{id}', [BlogController::class, 'DeleteBlog'])->name('delete.blog');


   Route::post('/update-slider/{id}', [HomeController::class, 'UpdateSliders']);
   Route::post('/update-slider-image/{id}', [HomeController::class, 'UpdateSliderImage']);

    Route::get('projects/{project}/previewhome', [ProjectController::class, 'ViewPreviewHome'])->name('projects.previewhome');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
