<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\InteractiveController;
use App\Http\Controllers\PodiumController;
use App\Http\Controllers\SignageController;
use App\Models\Contact;
use App\Models\IndexSlider;
use App\Models\InteractiveSlider;
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

//About
Route::post('create-about',[AboutController::class,'createAbout']);
Route::post('about-update/{id}',[AboutController::class,'updateAbout']);
Route::get('about-details',[AboutController::class,'aboutDetails']);

//Interactie panel
Route::post('create-interactive-slider',[InteractiveController::class,'createInteractiveSlider']);
Route::post('update-interactive-slider/{id}',[InteractiveController::class,'updateInteractiveSlider']);
Route::get('interactive-slider-details',[InteractiveController::class,'InteractiveSliderDetails']);

//Device
Route::post('create-device',[InteractiveController::class,'createDevice']);
Route::post('update-device-item/{id}',[InteractiveController::class,'updateDevice']);
Route::get('device-items-details',[InteractiveController::class,'deviceItems']);

//Specification
Route::post('create-interactive-specification',[InteractiveController::class,'createInteractiveSpecification']);
Route::post('update-interactive-specification/{id}',[InteractiveController::class,'updateInteractiveSpecification']);
Route::get('list-of-InteractiveSpecification',[InteractiveController::class,'listOfInteractiveSpecification']);

//video link
Route::post('create-video-link',[InteractiveController::class,'addVideoLink']);
Route::post('update-video-link/{id}',[InteractiveController::class,'updateVideoLink']);
Route::get('video-link-details',[InteractiveController::class,'videoLinkDetails']);

//Podium introduction
Route::post('create-podium-introduction',[PodiumController::class,'createPodiumIntroduction']);
Route::post('update-podium-introduction/{id}',[PodiumController::class,'updatePodiumIntroduction']);
Route::get('podium-introduction-details',[PodiumController::class,'podiumIntroductionDetails']);


//Podium
Route::post('create-a-podium',[PodiumController::class,'createPodium']);
Route::post('update-podium/{id}',[PodiumController::class,'updatePodium']);
Route::get('podium-details',[PodiumController::class,'podiumDetails']);

//Screen share
Route::post('create-screen-share',[PodiumController::class,'createScreenShare']);
Route::post('update-screen-share/{id}',[PodiumController::class,'updateScreenShare']);
Route::get('screen-share-details',[PodiumController::class,'screenShareDetails']);

//Wireless device
Route::post('create-wireless-device',[PodiumController::class,'createWirelessDevice']);
Route::post('update-wireless-device/{id}',[PodiumController::class,'updateWirelessDevice']);
Route::get('details-wireless-device',[PodiumController::class,'wirelessDeviceDetails']);

//Anotation
Route::post('create-anotation',[PodiumController::class,'createAnotation']);
Route::post('update-anotation/{id}',[PodiumController::class,'updateAnnotation']);
Route::get('anotation-details',[PodiumController::class,'anotationDetails']);

//Podium feature
Route::post('create-podium-feature',[PodiumController::class,'createPodiumFeature']);
Route::post('update-podium-feature/{id}',[PodiumController::class,'updatePodiumFeature']);
Route::get('details-podium-feature',[PodiumController::class,'detailsPodiumFeature']);

//Podium psenatation
Route::post('create-podium-presentation',[PodiumController::class,'createPodiumPresentation']);
Route::post('update-podium-presentation/{id}',[PodiumController::class,'updatePodiumPresentation']);
Route::get('podium-prsentation-list',[PodiumController::class,'podiumPrsentationList']);

//signage introduction
Route::post('create-signage-introduction',[SignageController::class,'createSignageIntroduction']);
Route::post('update-signage-introduction/{id}',[SignageController::class,'updateSignageIntroduction']);
Route::get('signage-introduction-details',[SignageController::class,'signageIntroductionDetails']);

//Signage
Route::post('signage-create',[SignageController::class,'createSignage']);
Route::post('update-a-signage-itme/{id}',[SignageController::class,'updateSignageItems']);
Route::get('signage-details',[SignageController::class,'signageDetails']);

//signage slider
Route::post('create-signage-slider',[SignageController::class,'createSignageSlider']);
Route::post('update-signage-slider/{id}',[SignageController::class,'updateSignageSlider']);
Route::get('details-signage-slider',[SignageController::class,'detailsOfSlignageSlider']);

//siognage specification
Route::post('create-signage-specification',[SignageController::class,'createSignageSpecification']);
Route::post('update-signage-specification-items/{id}',[SignageController::class,'updateSignageSpecification']);
Route::get('list-of-signage-specification',[SignageController::class,'listOfSignageSpecification']);

//signage video link
Route::post('signage-add-link',[SignageController::class,'addVideoLink']);
Route::post('update-signage-video-link/{id}',[SignageController::class,'updateVideoLink']);
Route::get('signage-video-link-details',[SignageController::class,'videoLinkDetails']);

//Contact introduction
Route::post('create-contact-introduction',[ContactController::class,'createContactIntroduction']);
Route::post('update-contact-introduction/{id}',[ContactController::class,'updateContactIntroduction']);
Route::get('contact-introduction-details',[ContactController::class,'contactIntroductionDetails']);

//Location
Route::post('create-a-location',[ContactController::class,'createLocation']);
Route::post('update-a-location/{id}',[ContactController::class,'updateLocation']);
Route::get('location-details',[ContactController::class,'locationDetails']);

//Form
Route::post('send-a-mail',[ContactController::class,'mailSent']);
});

