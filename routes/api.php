<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AttachmentsController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\FrontEndController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\UserAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group(['prefix'=>'public'],function (){
    Route::get('all-articles',[FrontEndController::class,'index']);
    Route::get('all-articles/{id}',[FrontEndController::class,'article_details']);
    Route::get('all-categories',[FrontEndController::class,'all_categories']);
    Route::get('get-partner',[AttachmentsController::class, 'get_partner']);
    Route::get('get-partner2',[AttachmentsController::class, 'get_partner2']);
    Route::get('get-reference',[AttachmentsController::class, 'get_reference']);
    Route::get('get-slider2',[AttachmentsController::class,'get_slider2']);
    Route::post('new-visitor',[FrontEndController::class,'new_visitor']);
    Route::post('contact-us',[FrontEndController::class,'sendContactEmail']);

});


//Admin Routes
Route::group(['prefix'=>'admin'],function (){
    //Unauthenticated Admin Routes
    Route::post('login',[AuthController::class,'login']);
    //Authenticated Admin Routes
    Route::group(['middleware'=>['auth:sanctum']],function (){
        Route::post('logout',[UserAuthController::class,'logout']);
        Route::post('upload-partner',[AttachmentsController::class, 'store_partner']);
        Route::get('get-partner',[AttachmentsController::class, 'get_partner']);
        Route::get('delete-partner/{id}',[AttachmentsController::class, 'delete_partner']);
        Route::post('upload-partner2',[AttachmentsController::class, 'store_partner2']);
        Route::get('get-partner2',[AttachmentsController::class, 'get_partner2']);
        Route::get('delete-partner2/{id}',[AttachmentsController::class, 'delete_partner2']);
        Route::post('upload-reference',[AttachmentsController::class, 'store_reference']);
        Route::get('get-reference',[AttachmentsController::class, 'get_reference']);
        Route::get('delete-reference/{id}',[AttachmentsController::class, 'delete_reference']);
        Route::post('upload-slider2',[AttachmentsController::class,'upload_slider2']);
        Route::get('get-slider2',[AttachmentsController::class,'get_slider2']);
        Route::get('get-counts',[DashboardController::class,'index']);
        Route::get('messages',[DashboardController::class,'contactUsMessages']);
        Route::get('messages/{id}',[DashboardController::class,'contactUsMessagesSeen']);
        Route::post('add-admin',[AuthController::class,'register']);
        Route::post('change-password',[AuthController::class,'change_password']);
        Route::get('all-admins',[AuthController::class,'all_admins']);
        Route::post('delete/{id}',[AuthController::class,'delete_user']);
        Route::group(['prefix'=>'articles'],function (){
            Route::post('create',[ArticleController::class,'store']);
            Route::post('update/{id}',[ArticleController::class,'update']);
            Route::get('delete/{id}',[ArticleController::class,'delete']);
            Route::get('get-article/{id}',[ArticleController::class,'article']);
            Route::get('all-articles',[ArticleController::class,'all_articles']);
        });
        Route::group(['prefix'=>'categories'],function (){
            Route::get('all',[CategoryController::class,'all_categories']);
            Route::post('create',[CategoryController::class,'store']);
            Route::post('update/{id}',[CategoryController::class,'update']);
            Route::get('delete/{id}',[CategoryController::class,'delete']);
            Route::get('/{id}',[CategoryController::class,'category']);

        });
    });

});
