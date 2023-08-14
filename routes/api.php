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
Route::post('index-slide-create',[IndexController::class,'createIndexSlider']);
Route::get('get-index-slider',[IndexController::class,'listOfIndexSlider']);
Route::delete('delete-index-slider/{id}',[IndexController::class,'deleteIndexSlider']);
Route::post('update-index-slider/{id}',[IndexController::class,'updateIndexSlider']);
Route::get('slider-item-list',[IndexController::class,'sliderItemList']);
Route::post('logout',[AuthController::class,'logout']);


//#Product
Route::post('create-a-product',[IndexController::class,'createProduct']);
Route::get('all-product',[IndexController::class,'allProduct']);
Route::delete('delete-product/{id}',[IndexController::class,'deleteProduct']);
Route::post('update-product/{id}',[IndexController::class,'updateProduct']);
Route::get('product-item',[IndexController::class,'productItemList']);


//#Panel
Route::post('create-pannel',[IndexController::class,'createPanel']);
Route::get('all-panel',[IndexController::class,'allPanel']);
Route::post('update-panel/{id}',[IndexController::class,'updatePanel']);

//#CSP
Route::post('create-solution-provider',[IndexController::class,'createCompleteSolutionProvider']);  
Route::get('detailsCompleteSolutionProvider',[IndexController::class,'detailsCompleteSolutionProvider']);
Route::post('update-complete-solution-provider/{id}',[IndexController::class,'updateCompleteSolutionProvider']);
Route::delete('delete-complete-solution-provider/{id}',[IndexController::class,'deleteCompleteSolutionProvider']);

//#Edu
Route::post('create-edu',[IndexController::class,'createEducation']);  
Route::post('update-edu/{id}',[IndexController::class,'updateEducation']);
Route::get('show-edu',[IndexController::class,'showEducation']);

//Feature product
Route::post('create-feature-product',[IndexController::class,'CreateFeatureProduct']);
Route::post('update-feature-product/{id}',[IndexController::class,'UpdateFeatureProduct']);
Route::get('feature-details',[IndexController::class,'FeatureProductDetails']);

//Conference
Route::post('create-conference',[IndexController::class,'CreateConference']);
Route::post('update-conference/{id}',[IndexController::class,'UpdateConference']);
Route::get('conference-details',[IndexController::class,'ConferenceDetails']);

//Honorable Client
Route::post('create-honorable-client',[IndexController::class,'createHonorableClient']);
Route::post('update-honorable-client/{id}',[IndexController::class,'updateHonorableClient']);
Route::get('honorable-client-details',[IndexController::class,'honorableClientDetails']);

//Our teams
Route::post('create-our-teams',[IndexController::class,'createOurTeam']);
Route::post('update-our-team-member/{id}',[IndexController::class,'updateOurTeam']);
Route::get('our-team-member-list',[IndexController::class,'ourTeamMemberList']);

//Case studies
Route::post('create-case-studies',[IndexController::class,'createCaseStudies']);
Route::post('update-case-studies/{id}',[IndexController::class,'updateCaseStudies']);
Route::get('case-study-list',[IndexController::class,'caseStudyList']);

//Testimonial
Route::post('create-testimonial',[IndexController::class,'createTestimonial']);
Route::post('update-testimonial/{id}',[IndexController::class,'updateTestimonial']);
Route::get('testimonial-list',[IndexController::class,'testimonialList']);
});

