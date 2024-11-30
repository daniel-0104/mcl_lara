<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ajaxController;
use App\Http\Controllers\authController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\teamController;
use App\Http\Controllers\userController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\orderController;
use App\Http\Controllers\clientController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ClientPerController;
use App\Http\Controllers\PricePlanController;
use App\Http\Controllers\StarterPlanController;

Route::get('loginPage',[authController::class,'loginPage'])->name('login#page');
Route::get('forgot-password',[authController::class,'forgotPage'])->name('forgot#page');
Route::post('rest-link',[authController::class,'resetLink'])->name('reset#link');
Route::get('validate-token/{token}',[authController::class,'validateToken'])->name('validate#token');
Route::post('validate-token-update',[authController::class,'validateTokenUpdate'])->name('validate#tokenUpdate');

//user
Route::get('/',[userController::class,'userHomePage'])->name('user#homePage');

Route::prefix('case')->group(function(){
    Route::get('list',[userController::class,'userCaseList'])->name('user#caseList');
    Route::get('view/{id}',[userController::class,'userCaseView'])->name('user#caseView');
    Route::get('filter/{type}',[userController::class,'userCaseFilter'])->name('user#caseFilter');
});

Route::get('service',[userController::class,'userServicePage'])->name('user#service');
Route::get('about',[userController::class,'userAboutPage'])->name('user#about');
Route::get('contact',[userController::class,'userContactPage'])->name('user#contact');
Route::post('message',[MessageController::class,'messageSend'])->name('message#send');

Route::middleware(['auth'])->group(function(){
    Route::get('/dashboard',[authController::class,'dashboard'])->name('dashboard');

    Route::middleware(['role:user'])->group(function(){
        Route::prefix('account')->group(function(){
            Route::get('profile',[userController::class,'userProfile'])->name('user#profile');
            Route::post('pfp/update/{id}',[userController::class,'userPfpUpdate'])->name('user#pfpUpdate');
            Route::get('change-pass',[userController::class,'userChangePass'])->name('user#changePass');
            Route::post('pass/update/{id}',[userController::class,'userPassUpdate'])->name('user#passUpdate');
        });

        Route::get('cart',[userController::class,'cartList'])->name('cart#list');

        Route::prefix('ajax')->group(function(){
            Route::get('cart',[ajaxController::class,'addToCart'])->name('ajax#addToCart');
            Route::post('remove',[ajaxController::class,'cartRemove'])->name('ajax#cartRemove');
            Route::get('checkout',[ajaxController::class,'cartCheckOut'])->name('ajax#cartCheckOut');
        });
    });

    Route::middleware(['role:admin,developer'])->group(function(){
        //profile
        Route::prefix('profile')->group(function(){
            Route::get('view',[adminController::class,'profileView'])->name('profile#view');
            Route::post('update/{id}',[adminController::class,'profileUpdate'])->name('profile#update');
            Route::post('pass-update/{id}',[adminController::class,'passUpdate'])->name('pass#update');
        });

        //teams
        Route::prefix('team')->group(function(){
            Route::get('add',[teamController::class,'teamAdd'])->name('team#add');
            Route::post('create',[teamController::class,'teamCreate'])->name('team#create');
            Route::get('list',[teamController::class,'teamList'])->name('team#list');
            Route::get('edit/{id}',[teamController::class,'teamEdit'])->name('team#edit');
            Route::post('update',[teamController::class,'teamUpdate'])->name('team#update');
            Route::get('delete/{id}',[teamController::class,'teamDelete'])->name('team#delete');
        });

        //orders
        Route::prefix('orders')->group(function(){
            Route::get('list',[orderController::class,'orderList'])->name('order#list');
            Route::get('view/{orderCode}',[orderController::class,'orderView'])->name('order#view');
            Route::get('status',[orderController::class,'orderStatus'])->name('order#status');
            Route::get('delete/{orderCode}',[orderController::class,'orderDelete'])->name('order#delete');
        });

        //website info
        Route::prefix('website')->group(function(){
            Route::get('add',[InfoController::class,'infoAdd'])->name('info#add');
            Route::post('create',[InfoController::class,'infoCreate'])->name('info#create');
            Route::get('list',[InfoController::class,'infoList'])->name('info#list');
            Route::post('update/{id}',[InfoController::class,'infoUpdate'])->name('info#update');
        });

        //message
        Route::prefix('message')->group(function(){
            Route::get('list',[MessageController::class,'adminMessagePage'])->name('admin#message');
            Route::get('reply/{id}',[MessageController::class,'adminMessageReply'])->name('admin#messageReply');
            Route::post('send/{id}',[MessageController::class,'adminMessageSend'])->name('admin#messageSend');
            Route::get('delete/{id}',[MessageController::class,'adminMessageDelete'])->name('admin#messageDelete');
        });

        //plan category
        Route::prefix('category')->group(function(){
            Route::get('list',[PlanController::class,'categoryList'])->name('category#list');
            Route::post('create',[PlanController::class,'categoryCreate'])->name('category#create');
            Route::get('edit/{id}',[PlanController::class,'categoryEdit'])->name('category#edit');
            Route::post('update',[PlanController::class,'categoryUpdate'])->name('category#update');
            Route::get('delete/{id}',[PlanController::class,'categoryDelete'])->name('category#delete');
        });

        //permission category
        Route::prefix('permission')->group(function(){
            Route::get('list',[ClientPerController::class,'perList'])->name('per#list');
            Route::post('create',[ClientPerController::class,'perCreate'])->name('per#create');
            Route::get('edit/{id}',[ClientPerController::class,'perEdit'])->name('per#edit');
            Route::post('update',[ClientPerController::class,'perUpdate'])->name('per#update');
            Route::get('delete/{id}',[ClientPerController::class,'perDelete'])->name('per#delete');
        });

        //price plan
        Route::prefix('plan')->group(function(){
            Route::get('add',[PricePlanController::class,'planAdd'])->name('plan#add');
            Route::post('create',[PricePlanController::class,'planCreate'])->name('plan#create');
            Route::get('list',[PricePlanController::class,'planList'])->name('plan#list');
            Route::get('view/{permission}',[PricePlanController::class,'planView'])->name('plan#view');
            Route::get('edit/{id}',[PricePlanController::class,'planEdit'])->name('plan#edit');
            Route::post('update',[PricePlanController::class,'planUpdate'])->name('plan#update');
            Route::get('delete/{id}',[PricePlanController::class,'planDelete'])->name('plan#delete');
            Route::get('delete/per/{projectPermission}',[PricePlanController::class,'planPermissionDelete'])->name('plan#permissionDelete');
        });

        //starter plan
        Route::prefix('start-plan')->group(function(){
            Route::get('add',[StarterPlanController::class,'startPlanAdd'])->name('start#planAdd');
            Route::post('create',[StarterPlanController::class,'startPlanCreate'])->name('start#planCreate');
            Route::get('list',[StarterPlanController::class,'startPlanList'])->name('start#planList');
            Route::get('view/{permission}',[StarterPlanController::class,'startPlanView'])->name('start#planView');
            Route::get('edit/{id}',[StarterPlanController::class,'startPlanEdit'])->name('start#planEdit');
            Route::post('update',[StarterPlanController::class,'startPlanUpdate'])->name('start#planUpdate');
            Route::get('delete/{id}',[StarterPlanController::class,'startPlanDelete'])->name('start#planDelete');
            Route::get('delete/per/{projectPermission}',[StarterPlanController::class,'startPlanPerDelete'])->name('start#planPerDelete');
        });

        //clients logo
        Route::prefix('logo')->group(function(){
            Route::get('list',[clientController::class,'logoList'])->name('logo#list');
            Route::post('create',[clientController::class,'logoCreate'])->name('logo#create');
            Route::get('edit/{id}',[clientController::class,'logoEdit'])->name('logo#edit');
            Route::post('update',[clientController::class,'logoUpdate'])->name('logo#update');
            Route::get('delete/{id}',[clientController::class,'logoDelete'])->name('logo#delete');
        });

        //client reviews
        Route::prefix('review')->group(function(){
            Route::get('list',[clientController::class,'reviewList'])->name('review#list');
            Route::post('create',[clientController::class,'reviewCreate'])->name('review#create');
            Route::get('edit/{id}',[clientController::class,'reviewEdit'])->name('review#edit');
            Route::post('update',[clientController::class,'reviewUpdate'])->name('review#update');
            Route::get('delete/{id}',[clientController::class,'reviewDelete'])->name('review#delete');
        });

        //client account
        Route::prefix('account')->group(function(){
            Route::get('add',[clientController::class,'accountAdd'])->name('account#add');
            Route::post('create',[clientController::class,'accountCreate'])->name('account#create');
            Route::get('list',[clientController::class,'accountList'])->name('account#list');
            Route::get('edit/{id}',[clientController::class,'accountEdit'])->name('account#edit');
            Route::post('update',[clientController::class,'accountUpdate'])->name('account#update');
            Route::get('delete/{id}',[clientController::class,'accountDelete'])->name('account#delete');
        });

        //client projects
        Route::prefix('project')->group(function(){
            Route::get('add',[ProjectController::class,'projectAdd'])->name('project#add');
            Route::post('create',[ProjectController::class,'projectCreate'])->name('project#create');
            Route::get('list',[ProjectController::class,'projectList'])->name('project#list');
            Route::get('edit/{id}',[ProjectController::class,'projectEdit'])->name('project#edit');
            Route::post('update',[ProjectController::class,'projectUpdate'])->name('project#update');
            Route::get('delete/{id}',[ProjectController::class,'projectDelete'])->name('project#delete');
        });
    });
});
