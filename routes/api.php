<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\IndexController;
use App\Models\IndexSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//auth
Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);


Route::group(['middleware' => ['auth:sanctum']], function () {

//Index

//#Index slider
Route::post('index-slide-create',[IndexController::class,'create_index_slider']);
Route::get('get-index-slider',[IndexController::class,'show_slider_index']);
Route::delete('delete-index-slider/{id}',[IndexController::class,'delete_index_slider']);
Route::post('update-index-slider/{id}',[IndexController::class,'update_index_slider']);
Route::get('slider-item-list',[IndexController::class,'slider_item_list']);
Route::post('logout',[AuthController::class,'logout']);


//#Product
Route::post('create-a-product',[IndexController::class,'create_product']);
Route::get('show-product',[IndexController::class,'show_product']);
Route::delete('delete-product/{id}',[IndexController::class,'delete_product']);
Route::post('update-product/{id}',[IndexController::class,'update_product']);
Route::get('product-item',[IndexController::class,'product_item_list']);


//#Panel
Route::post('create-pannel',[IndexController::class,'create_panel']);
Route::get('show-panel',[IndexController::class,'showPanel']);
Route::post('update-panel/{id}',[IndexController::class,'updatePanel']);

//#CSP
Route::post('create-solution-provider',[IndexController::class,'createSolutionProvider']);  
Route::get('show-csp',[IndexController::class,'showCsp']);
Route::post('update-csp/{id}',[IndexController::class,'updateCsp']);
Route::delete('delete-csp/{id}',[IndexController::class,'deleteCsp']);

//#Edu
Route::post('create-edu',[IndexController::class,'createEdu']);  

});

