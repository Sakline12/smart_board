<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DerpartmentController;
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
Route::delete('delete-index-slider/{id}',[IndexController::class,'deleteIndexSlider']);
Route::post('update-index-slider/{id}',[IndexController::class,'updateIndexSlider']);
Route::get('slider-item-list',[IndexController::class,'sliderItemList']);
Route::post('logout',[AuthController::class,'logout']);


//#Product
Route::post('create-a-product',[IndexController::class,'createProduct']);
Route::delete('delete-product/{id}',[IndexController::class,'deleteProduct']);
Route::post('update-product/{id}',[IndexController::class,'updateProduct']);
Route::get('product-item',[IndexController::class,'productItemList']);


//#Panel
Route::post('create-pannel',[IndexController::class,'createPanel']);
Route::post('update-panel/{id}',[IndexController::class,'updatePanel']);
Route::get('panel-list',[IndexController::class,'panelList']);


//#CSP
Route::post('create-solution-provider',[IndexController::class,'createCompleteSolutionProvider']);  
Route::post('update-complete-solution-provider/{id}',[IndexController::class,'updateCompleteSolutionProvider']);
Route::delete('delete-complete-solution-provider/{id}',[IndexController::class,'deleteCompleteSolutionProvider']);
Route::get('complete-solution-provider-details',[IndexController::class,'detailsCompleteSolutionProvider']);


//#Edu
Route::post('create-education',[IndexController::class,'createEducation']);  
Route::post('update-education/{id}',[IndexController::class,'updateEducation']);
Route::get('education-info',[IndexController::class,'educationInfo']);


//Feature product
Route::post('create-feature-product',[IndexController::class,'createFeatureProduct']);
Route::post('update-feature-product/{id}',[IndexController::class,'updateFeatureProduct']);
Route::get('feature-details',[IndexController::class,'featureProductDetails']);

//Conference
Route::post('create-conference',[IndexController::class,'CreateConference']);
Route::post('update-conference/{id}',[IndexController::class,'UpdateConference']);
Route::get('conference-info',[IndexController::class,'conferenceInfo']);

//Honorable Client
Route::post('create-honorable-client',[IndexController::class,'createHonorableClient']);
Route::post('update-honorable-client/{id}',[IndexController::class,'updateHonorableClient']);
Route::get('client-info',[IndexController::class,'clientInfo']);

//Our teams
Route::post('create-our-teams',[IndexController::class,'createOurTeam']);
Route::post('update-our-team-member/{id}',[IndexController::class,'updateOurTeam']);
Route::get('team-memeber-info',[IndexController::class,'teamMemberInfo']);


//Case studies
Route::post('create-case-studies',[IndexController::class,'createCaseStudies']);
Route::post('update-case-studies/{id}',[IndexController::class,'updateCaseStudies']);
Route::get('case-study-info',[IndexController::class,'caseStudyInfo']);

//Testimonial
Route::post('create-testimonial',[IndexController::class,'createTestimonial']);
Route::post('update-testimonial/{id}',[IndexController::class,'updateTestimonial']);
Route::get('testimonial-info',[IndexController::class,'testimonialInfo']);

//About
Route::post('create-about',[AboutController::class,'createAbout']);
Route::post('about-update/{id}',[AboutController::class,'updateAbout']);
Route::get('about-info',[AboutController::class,'aboutInformation']);

//Interactie panel
Route::post('create-interactive-slider',[InteractiveController::class,'createInteractiveSlider']);
Route::post('update-interactive-slider/{id}',[InteractiveController::class,'updateInteractiveSlider']);
Route::get('interactive-slider-info',[InteractiveController::class,'InteractiveSliderInfo']);

//Device
Route::post('create-device',[InteractiveController::class,'createDevice']);
Route::post('update-device-item/{id}',[InteractiveController::class,'updateDevice']);
Route::get('device-info',[InteractiveController::class,'deviceInfo']);

//Specification
Route::post('create-interactive-specification',[InteractiveController::class,'createInteractiveSpecification']);
Route::post('update-interactive-specification/{id}',[InteractiveController::class,'updateInteractiveSpecification']);
Route::get('info-of-InteractiveSpecification',[InteractiveController::class,'infoOfInteractiveSpecification']);


//video link
Route::post('create-video-link',[InteractiveController::class,'addVideoLink']);
Route::post('update-video-link/{id}',[InteractiveController::class,'updateVideoLink']);
Route::get('video-link-info',[InteractiveController::class,'videoLinkInfo']);



//Podium introduction
Route::post('create-podium-introduction',[PodiumController::class,'createPodiumIntroduction']);
Route::post('update-podium-introduction/{id}',[PodiumController::class,'updatePodiumIntroduction']);
Route::get('podium-introduction-info',[PodiumController::class,'podiumIntroductionInfo']);

//Podium
Route::post('create-a-podium',[PodiumController::class,'createPodium']);
Route::post('update-podium/{id}',[PodiumController::class,'updatePodium']);
Route::get('podium-info',[PodiumController::class,'podiumInfo']);

//Screen share
Route::post('create-screen-share',[PodiumController::class,'createScreenShare']);
Route::post('update-screen-share/{id}',[PodiumController::class,'updateScreenShare']);
Route::get('screen-share-info',[PodiumController::class,'screenShareInfo']);

//Wireless device
Route::post('create-wireless-device',[PodiumController::class,'createWirelessDevice']);
Route::post('update-wireless-device/{id}',[PodiumController::class,'updateWirelessDevice']);
Route::get('info-wireless-device',[PodiumController::class,'wirelessDeviceInfo']);

//Anotation
Route::post('create-anotation',[PodiumController::class,'createAnotation']);
Route::post('update-anotation/{id}',[PodiumController::class,'updateAnnotation']);
Route::get('anotation-info',[PodiumController::class,'anotationInfo']);

//Podium feature
Route::post('create-podium-feature',[PodiumController::class,'createPodiumFeature']);
Route::post('update-podium-feature/{id}',[PodiumController::class,'updatePodiumFeature']);
Route::get('info-podium-feature',[PodiumController::class,'infoPodiumFeature']);

//Podium psenatation
Route::post('create-podium-presentation',[PodiumController::class,'createPodiumPresentation']);
Route::post('update-podium-presentation/{id}',[PodiumController::class,'updatePodiumPresentation']);
Route::get('podium-prsentation-info',[PodiumController::class,'podiumPrsentationInfo']);


//signage introduction
Route::post('create-signage-introduction',[SignageController::class,'createSignageIntroduction']);
Route::post('update-signage-introduction/{id}',[SignageController::class,'updateSignageIntroduction']);
Route::get('signage-introduction-info',[SignageController::class,'signageIntroductionInfo']);

//Signage
Route::post('signage-create',[SignageController::class,'createSignage']);
Route::post('update-a-signage-itme/{id}',[SignageController::class,'updateSignageItems']);
Route::get('signage-info',[SignageController::class,'signageInfo']);

//signage slider
Route::post('create-signage-slider',[SignageController::class,'createSignageSlider']);
Route::post('update-signage-slider/{id}',[SignageController::class,'updateSignageSlider']);
Route::get('signage-slider-info',[SignageController::class,'infoOfSlignageSlider']);

//siognage specification
Route::post('create-signage-specification',[SignageController::class,'createSignageSpecification']);
Route::post('update-signage-specification-items/{id}',[SignageController::class,'updateSignageSpecification']);
Route::get('info-of-signage-specification',[SignageController::class,'infoOfSignageSpecification']);

//signage video link
Route::post('signage-add-link',[SignageController::class,'addVideoLink']);
Route::post('update-signage-video-link/{id}',[SignageController::class,'updateVideoLink']);
Route::get('signage-video-link-info',[SignageController::class,'videoLinkInfo']);

//Contact introduction
Route::post('create-contact-introduction',[ContactController::class,'createContactIntroduction']);
Route::post('update-contact-introduction/{id}',[ContactController::class,'updateContactIntroduction']);
Route::get('contact-introduction-info',[ContactController::class,'contactIntroductionInfo']);

//Location
Route::post('create-a-location',[ContactController::class,'createLocation']);
Route::post('update-a-location/{id}',[ContactController::class,'updateLocation']);

//Form
Route::post('send-a-mail',[ContactController::class, 'sendEmail']);
Route::delete('delete-a-mail/{id}',[ContactController::class,'deleteMail']);

Route::get('mail-list',[ContactController::class,'mailList']);
//Title
Route::post('create-title',[DepartmentController::class,'createTitle']);
Route::post('update-title/{id}',[DepartmentController::class,'updateTitle']);
Route::get('title-list',[DepartmentController::class,'titleList']);


//Sub title
Route::post('create-sub-title',[DepartmentController::class,'createSubTitle']);
Route::get('sub-title-list',[DepartmentController::class,'subTitleList']);
Route::delete('delete-a-subtitle/{id}',[DepartmentController::class,'deleteSubtitle']);
Route::post('update-a-subtitle/{id}',[DepartmentController::class,'updateSubTitle']);

//Designation
Route::post('create-designation',[DepartmentController::class,'createDesignation']);
Route::post('update-designation/{id}',[DepartmentController::class,'updateDesignation']);
Route::get('designation-list',[DepartmentController::class,'DesignationList']);
Route::delete('delete-designation/{id}',[DepartmentController::class,'designationDelete']);

//Department
Route::post('create-department',[DepartmentController::class,'createDepartment']);
Route::post('update-deprtment/{id}',[DepartmentController::class,'updateDepartment']);
Route::get('department-list',[DepartmentController::class,'DepartmentList']);
Route::delete('delete-department/{id}',[DepartmentController::class,'departmentDelete']);

//Device image
Route::post('create-image-device',[DepartmentController::class,'createDeviceImage']);
Route::post('update-device-image/{id}',[DepartmentController::class,'updateDeviceImage']);
Route::get('device-image-list',[DepartmentController::class,'listOfDeviceImage']);

});

//Everybody acccess
Route::group(['prefix' => 'open'], function () {
    Route::get('get-index-slider',[IndexController::class,'listOfIndexSlider']);
    Route::get('all-product',[IndexController::class,'allProduct']);
    Route::get('all-panel',[IndexController::class,'allPanel']);
    Route::get('info-complete-solution-provider',[IndexController::class,'infoCompleteSolutionProvider']);
    Route::get('details-education',[IndexController::class,'educationDetails']);
    Route::get('feature-product-info',[IndexController::class,'featureInfo']);
    Route::get('conference-details',[IndexController::class,'ConferenceDetails']);
    Route::get('honorable-client-details',[IndexController::class,'honorableClientDetails']);
    Route::get('our-team-member-list',[IndexController::class,'ourTeamMemberList']);
    Route::get('case-study-list',[IndexController::class,'caseStudyList']);
    Route::get('testimonial-list',[IndexController::class,'testimonialList']);
    Route::get('about-details',[AboutController::class,'aboutDetails']);
    Route::get('interactive-slider-details',[InteractiveController::class,'InteractiveSliderDetails']);
    Route::get('device-items-details',[InteractiveController::class,'deviceItems']);
    Route::get('list-of-InteractiveSpecification',[InteractiveController::class,'listOfInteractiveSpecification']);
    Route::get('video-link-details',[InteractiveController::class,'videoLinkDetails']);
    Route::get('podium-introduction-details',[PodiumController::class,'podiumIntroductionDetails']);
    Route::get('podium-details',[PodiumController::class,'podiumDetails']);
    Route::get('screen-share-details',[PodiumController::class,'screenShareDetails']);
    Route::get('details-wireless-device',[PodiumController::class,'wirelessDeviceDetails']);
    Route::get('anotation-details',[PodiumController::class,'anotationDetails']);
    Route::get('details-podium-feature',[PodiumController::class,'detailsPodiumFeature']);
    Route::get('podium-prsentation-list',[PodiumController::class,'podiumPrsentationList']);
    Route::get('signage-introduction-details',[SignageController::class,'signageIntroductionDetails']);
    Route::get('signage-details',[SignageController::class,'signageDetails']);
    Route::get('details-signage-slider',[SignageController::class,'detailsOfSlignageSlider']);
    Route::get('list-of-signage-specification',[SignageController::class,'listOfSignageSpecification']);
    Route::get('signage-video-link-details',[SignageController::class,'videoLinkDetails']);
    Route::get('contact-introduction-details',[ContactController::class,'contactIntroductionDetails']);
    Route::get('location-details',[ContactController::class,'locationDetails']);
    Route::get('unauthorized', function () {
        return response()->json(['status'=>false,'message' => 'Unauthorized.'], 401);
    })->name('unauthorized');
});

//Invalid route
Route::any('{url}', function () {
    return response()->json([
        'status' => false,
        'message' => 'Route Not Found!',
        'data' => []
    ], 404);
})->where('url', '.*');


