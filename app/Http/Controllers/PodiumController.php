<?php

namespace App\Http\Controllers;

use App\Models\Anotation;
use App\Models\Podium;
use App\Models\PodiumFeature;
use App\Models\PodiumIntroduction;
use App\Models\PodiumPresentation;
use App\Models\ScreenShare;
use App\Models\WirelessDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PodiumController extends Controller
{
    //Podium introduction

    public function createPodiumIntroduction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_id' => 'required',
            'sub_title' => 'required',
            'description_one' => 'required',
            'description_two' => 'required',
            'button_text_one' => 'required',
            'button_text_two' => 'required',
            'button_link_one' => 'required',
            'button_link_two' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 403);
        }

        if ($request->input('title_id') != 15) {
            return response()->json([
                'status' => false,
                'message' => 'Podium introduction can only be created with title equal to 15',
                'data' => [],
            ], 400);
        }

        $existingPanel = PodiumIntroduction::where('title_id', $request->input('title_id'))->first();
        if ($existingPanel) {
            return response()->json([
                'status' => false,
                'message' => 'Podium introduction with the same title_id already exists',
                'data' => [],
            ], 409);
        }

        $podium = new PodiumIntroduction();
        $podium->title_id = $request->input('title_id');
        $podium->sub_title = $request->input('sub_title');
        $podium->description_one = $request->input('description_one');
        $podium->description_two = $request->input('description_two');
        $podium->button_text_one = $request->input('button_text_one');
        $podium->button_text_two = $request->input('button_text_two');
        $podium->button_link_one = $request->input('button_link_one');
        $podium->button_link_two = $request->input('button_link_two');
        $podium->save();


        if ($podium->save()) {
            $data = [
                'status' => true,
                'message' => 'Podium Introduction successfully created',
                'data' => $podium,
            ];
            return response()->json($data, 201);
        } else {
            $data = [
                'status' => false,
                'message' => 'Error occurred',
                'data' => [],
            ];
            return response()->json($data, 501);
        }
    }

    public function updatePodiumIntroduction(Request $request, $id)
    {
        $Podium = PodiumIntroduction::find($id);
        if (!$Podium) {
            return response()->json([
                'status' => false,
                'message' => 'Podium introduction links not found',
            ], 404);
        }

        $Podium->update([
            'title_id' => $request->title_id,
            'sub_title' => $request->sub_title,
            'description_one' => $request->description_one,
            'description_two' => $request->description_two,
            'button_text_one' => $request->button_text_one,
            'button_text_two' => $request->button_text_two,
            'button_link_one' => $request->button_link_one,
            'button_link_two' => $request->button_link_two,
            'is_active' => $request->is_active,
        ]);

        $all_data = [
            'title_id' => $Podium->title_id,
            'sub_title' => $Podium->sub_title,
            'description_one' => $Podium->description_one,
            'description_two' => $Podium->description_two,
            'button_text_one' => $Podium->button_text_one,
            'button_text_two' => $Podium->button_text_two,
            'button_link_one' => $Podium->button_link_one,
            'button_link_two' => $Podium->button_link_two,
            'is_active' => $Podium->is_active,
        ];

        $data = [
            'status' => 200,
            'message' => "Podium introduction updated successfully",
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function podiumIntroductionDetails()
    {
        $podium = PodiumIntroduction::where('is_active', true)->first();
        if ($podium) {
            $data = [
                'status' => true,
                'message' => 'Here podium introduction details:',
                'title' => $podium->title->name,
                'data' => $podium,

            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => false,
                'message' => 'This is not active',
                'data' => $podium,

            ];
            return response()->json($data, 404);
        }
    }

    public function podiumIntroductionInfo()
    {
        $data = PodiumIntroduction::first();

        $data = [
            'status' => true,
            'message' => 'Here podium info details:',
            'title' => $data->title->name,
            'data' => $data,

        ];
        return response()->json($data, 200);
    }



    //Podium
    public function createPodium(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title_id' => 'required',
            'description' => 'required',
            'background_image' => 'required',
            'image' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 403);
        }

        if ($request->input('title_id') != 16) {
            return response()->json([
                'status' => false,
                'message' => 'Podium can only be created with title equal to 16',
                'data' => [],
            ], 400);
        }

        $existingPanel = Podium::where('title_id', $request->input('title_id'))->first();
        if ($existingPanel) {
            return response()->json([
                'status' => false,
                'message' => 'Podium with the same title_id already exists',
                'data' => [],
            ], 409);
        }


        $podium = new Podium();
        if ($panelimage = $request->file('image')) {
            $imageName1 = time() . '-' . uniqid() . '.' . $panelimage->getClientOriginalExtension();
            $panelimage->move(public_path('podium'), $imageName1);
        }

        if ($panelimage1 = $request->file('background_image')) {
            $imageName2 = time() . '-' . uniqid() . '.' . $panelimage1->getClientOriginalExtension();
            $panelimage1->move(public_path('podium'), $imageName2);
        }

        $podium->title_id = $request->title_id;
        $podium->description = $request->description;
        $podium->image = $imageName1;
        $podium->background_image = $imageName2;

        $podium->save();

        if ($podium->save()) {
            $data = [
                'status' => true,
                'message' => 'Podium successfully created',
                'data' => $podium,
            ];
            return response()->json($data, 201);
        } else {
            $data = [
                'status' => false,
                'message' => 'Error occurred',
                'data' => [],
            ];
            return response()->json($data, 501);
        }
    }

    public function updatePodium(Request $request, $id)
    {
        $podium = Podium::find($id);
        if (!$podium) {
            return response()->json([
                'status' => false,
                'message' => 'Podium not found',
            ], 404);
        }

        if ($image1 = $request->file('image')) {
            if ($podium->image && file_exists(public_path('podium') . '/' . $podium->image)) {
                unlink(public_path('podium') . '/' . $podium->image);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('podium'), $imageName1);

            $podium->image = $imageName1;
        }

        if ($image2 = $request->file('background_image')) {
            if ($podium->background_image && file_exists(public_path('podium') . '/' . $podium->background_image)) {
                unlink(public_path('podium') . '/' . $podium->background_image);
            }

            $imageName2 = time() . '-' . uniqid() . '.' . $image2->getClientOriginalExtension();
            $image2->move(public_path('podium'), $imageName2);

            $podium->background_image = $imageName2;
        }

        $podium->title_id = $request->title_id;
        $podium->description = $request->description;
        $podium->is_active = $request->is_active;
        $podium->save();

        $all_data = [
            'description' => $podium->description,
            'image' => $podium->image,
            'background_image' => $podium->background_image,
            'is_active' => $podium->is_active
        ];

        $data = [
            'status' => 200,
            'message' => "Podium updated successfully",
            'title_id' => $podium->title->name,
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function podiumDetails()
    {
        $data = Podium::where('is_active', true)->first();

        $data = [
            'status' => true,
            'message' => 'Here podium details:',
            'title' => $data->title->name,
            'data' => $data,

        ];
        return response()->json($data, 200);
    }

    public function podiumInfo()
    {
        $podium = Podium::first();
        if ($podium) {
            $data = [
                'status' => true,
                'message' => 'Here podium details:',
                'title' => $podium->title->name,
                'data' => $podium,

            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => false,
                'message' => 'This is not Active',
                'data' => $podium,

            ];
            return response()->json($data, 404);
        }
    }

    //Screen share
    public function createScreenShare(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_id' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 403);
        }

        if ($request->input('title_id') != 17) {
            return response()->json([
                'status' => false,
                'message' => 'Screen share can only be created with title equal to 17',
                'data' => [],
            ], 400);
        }

        $existingPanel = ScreenShare::where('title_id', $request->input('title_id'))->first();
        if ($existingPanel) {
            return response()->json([
                'status' => false,
                'message' => 'Screen share with the same title_id already exists',
                'data' => [],
            ], 409);
        }


        $screenshare = new ScreenShare();
        $screenshare->title_id = $request->title_id;
        $screenshare->description = $request->description;
        $screenshare->save();

        if ($screenshare->save()) {
            $data = [
                'status' => true,
                'message' => 'Screen share successfully created',
                'data' => $screenshare,
            ];
            return response()->json($data, 201);
        } else {
            $data = [
                'status' => false,
                'message' => 'Error occurred',
                'data' => [],
            ];
            return response()->json($data, 501);
        }
    }

    public function updateScreenShare(Request $request, $id)
    {
        $Screenshare = ScreenShare::find($id);
        if (!$Screenshare) {
            return response()->json([
                'status' => false,
                'message' => 'Screen share not found',
            ], 404);
        }

        $Screenshare->update([
            'title_id' => $request->title_id,
            'description' => $request->description,
            'is_active' => $request->is_active,
        ]);

        $all_data = [
            'title_id' => $Screenshare->title_id,
            'description' => $Screenshare->description,
            'is_active' => $Screenshare->is_active,
        ];

        $data = [
            'status' => 200,
            'message' => "Screen share updated successfully",
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function screenShareDetails()
    {
        $data = ScreenShare::where('is_active', true)->first();

        $data = [
            'status' => true,
            'message' => 'Here screen share details:',
            'title' => $data->title->name,
            'data' => $data,

        ];
        return response()->json($data, 200);
    }

    public function screenShareInfo()
    {
        $screenshare = ScreenShare::first();
        if ($screenshare) {
            $data = [
                'status' => true,
                'message' => 'Here screen share details:',
                'title' => $screenshare->title->name,
                'data' => $screenshare,

            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => false,
                'message' => 'This is not active',
                'data' => $screenshare,

            ];
            return response()->json($data, 404);
        }
    }

    //Wireless device
    public function createWirelessDevice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_id' => 'required',
            'image_one' => 'required',
            'image_two' => 'required',
            'image_three' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 403);
        }

        if ($request->input('title_id') != 18) {
            return response()->json([
                'status' => false,
                'message' => 'Wireless device can only be created with title equal to 18',
                'data' => [],
            ], 400);
        }

        $wirelessdevice = WirelessDevice::where('title_id', $request->input('title_id'))->first();
        if ($wirelessdevice) {
            return response()->json([
                'status' => false,
                'message' => 'Wireless device with the same title_id already exists',
                'data' => [],
            ], 409);
        }


        $wirelessdevice = new WirelessDevice();
        if ($panelimage = $request->file('image_one')) {
            $imageName1 = time() . '-' . uniqid() . '.' . $panelimage->getClientOriginalExtension();
            $panelimage->move(public_path('wirelessdevice'), $imageName1);
        }

        if ($panelimage1 = $request->file('image_two')) {
            $imageName2 = time() . '-' . uniqid() . '.' . $panelimage1->getClientOriginalExtension();
            $panelimage1->move(public_path('wirelessdevice'), $imageName2);
        }

        if ($panelimage2 = $request->file('image_three')) {
            $imageName3 = time() . '-' . uniqid() . '.' . $panelimage2->getClientOriginalExtension();
            $panelimage2->move(public_path('wirelessdevice'), $imageName3);
        }

        $wirelessdevice->title_id = $request->title_id;
        $wirelessdevice->image_one = $imageName1;
        $wirelessdevice->image_two = $imageName2;
        $wirelessdevice->image_three = $imageName3;
        $wirelessdevice->save();

        if ($wirelessdevice->save()) {
            $data = [
                'status' => true,
                'message' => 'Wireless device successfully created',
                'data' => $wirelessdevice,
            ];
            return response()->json($data, 201);
        } else {
            $data = [
                'status' => false,
                'message' => 'Error occurred',
                'data' => [],
            ];
            return response()->json($data, 501);
        }
    }

    public function updateWirelessDevice(Request $request, $id)
    {
        $wirelessdevice = WirelessDevice::find($id);
        if (!$wirelessdevice) {
            return response()->json([
                'status' => false,
                'message' => 'Wireless device not found',
            ], 404);
        }

        if ($image1 = $request->file('image_one')) {
            if ($wirelessdevice->image_one && file_exists(public_path('wirelessdevice') . '/' . $wirelessdevice->image_one)) {
                unlink(public_path('wirelessdevice') . '/' . $wirelessdevice->image_one);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('wirelessdevice'), $imageName1);

            $wirelessdevice->image_one = $imageName1;
        }

        if ($image2 = $request->file('image_two')) {
            if ($wirelessdevice->image_two && file_exists(public_path('wirelessdevice') . '/' . $wirelessdevice->image_two)) {
                unlink(public_path('wirelessdevice') . '/' . $wirelessdevice->image_two);
            }

            $imageName2 = time() . '-' . uniqid() . '.' . $image2->getClientOriginalExtension();
            $image2->move(public_path('wirelessdevice'), $imageName2);

            $wirelessdevice->image_two = $imageName2;
        }

        if ($image3 = $request->file('image_three')) {
            if ($wirelessdevice->image_three && file_exists(public_path('wirelessdevice') . '/' . $wirelessdevice->image_three)) {
                unlink(public_path('wirelessdevice') . '/' . $wirelessdevice->image_three);
            }

            $imageName3 = time() . '-' . uniqid() . '.' . $image3->getClientOriginalExtension();
            $image3->move(public_path('wirelessdevice'), $imageName3);

            $wirelessdevice->image_three = $imageName3;
        }

        $wirelessdevice->title_id = $request->title_id;
        $wirelessdevice->is_active = $request->is_active;
        $wirelessdevice->save();

        $all_data = [
            'description' => $wirelessdevice->description,
            'image_one' => $wirelessdevice->image_one,
            'image_two' => $wirelessdevice->image_two,
            'image_three' => $wirelessdevice->image_three
        ];

        $data = [
            'status' => 200,
            'message' => "Wireless device updated successfully",
            'title_id' => $wirelessdevice->title->name,
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function wirelessDeviceDetails()
    {
        $data = WirelessDevice::where('is_active', true)->first();

        $data = [
            'status' => true,
            'message' => 'Here Wireless device details:',
            'title' => $data->title->name,
            'data' => $data,

        ];
        return response()->json($data, 200);
    }

    public function wirelessDeviceInfo()
    {
        $data = WirelessDevice::first();

        $data = [
            'status' => true,
            'message' => 'Here Wireless device details:',
            'title' => $data->title->name,
            'data' => $data,

        ];
        return response()->json($data, 200);
    }

    //Anotation
    public function createAnotation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_id' => 'required',
            'sub_title' => 'required',
            'field_one' => 'required',
            'field_two' => 'required',
            'field_three' => 'required',
            'background_image' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 403);
        }

        if ($request->input('title_id') != 19) {
            return response()->json([
                'status' => false,
                'message' => 'Anotation can only be created with title equal to 19',
                'data' => [],
            ], 400);
        }

        $existingPanel = Anotation::where('title_id', $request->input('title_id'))->first();
        if ($existingPanel) {
            return response()->json([
                'status' => false,
                'message' => 'Anotation with the same title_id already exists',
                'data' => [],
            ], 409);
        }


        $anotation = new Anotation();
        if ($panelimage = $request->file('background_image')) {
            $imageName1 = time() . '-' . uniqid() . '.' . $panelimage->getClientOriginalExtension();
            $panelimage->move(public_path('anotation'), $imageName1);
        }


        $anotation->title_id = $request->title_id;
        $anotation->background_image = $imageName1;
        $anotation->sub_title = $request->sub_title;
        $anotation->field_one = $request->field_one;
        $anotation->field_two = $request->field_two;
        $anotation->field_three = $request->field_three;
        $anotation->save();

        if ($anotation->save()) {
            $data = [
                'status' => true,
                'message' => 'Anotation device successfully created',
                'data' => $anotation,
            ];
            return response()->json($data, 201);
        } else {
            $data = [
                'status' => false,
                'message' => 'Error occurred',
                'data' => [],
            ];
            return response()->json($data, 501);
        }
    }

    public function updateAnnotation(Request $request, $id)
    {
        $anotation = Anotation::find($id);
        if (!$anotation) {
            return response()->json([
                'status' => false,
                'message' => 'Anotation not found',
            ], 404);
        }

        if ($image1 = $request->file('background_image')) {
            if ($anotation->background_image && file_exists(public_path('anotation') . '/' . $anotation->background_image)) {
                unlink(public_path('anotation') . '/' . $anotation->background_image);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('anotation'), $imageName1);

            $anotation->background_image = $imageName1;
        }

        $anotation->title_id = $request->title_id;
        $anotation->sub_title = $request->sub_title;
        $anotation->field_one = $request->field_one;
        $anotation->field_two = $request->field_two;
        $anotation->field_three = $request->field_three;
        $anotation->is_active = $request->is_active;
        $anotation->save();

        $all_data = [
            'sub_title' => $anotation->sub_title,
            'field_one' => $anotation->field_one,
            'field_two' => $anotation->field_two,
            'field_three' => $anotation->field_three,
            'background_image' => $anotation->background_image,
            'is_active' => $anotation->is_active
        ];

        $data = [
            'status' => 200,
            'message' => "Anotation updated successfully",
            'title_id' => $anotation->title->name,
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function anotationDetails()
    {
        $data = Anotation::where('is_active', true)->first();
        $title = $data->title->name;
        $data = [
            'status' => true,
            'message' => 'Here anotation details:',
            'title' => $title,
            'data' => $data,

        ];
        return response()->json($data, 200);
    }

    public function anotationInfo()
    {
        $data = Anotation::first();
        $title = $data->title->name;
        $data = [
            'status' => true,
            'message' => 'Here anotation details:',
            'title' => $title,
            'data' => $data,

        ];
        return response()->json($data, 200);
    }

    //Features
    public function createPodiumFeature(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_id' => 'required',
            'description' => 'required',
            'background_image' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 403);
        }

        if ($request->input('title_id') != 20) {
            return response()->json([
                'status' => false,
                'message' => 'Podium feature can only be created with title equal to 20',
                'data' => [],
            ], 400);
        }

        $existingPanel = PodiumFeature::where('title_id', $request->input('title_id'))->first();
        if ($existingPanel) {
            return response()->json([
                'status' => false,
                'message' => 'Podium feature with the same title_id already exists',
                'data' => [],
            ], 409);
        }

        $feature = new PodiumFeature();
        if ($panelimage1 = $request->file('background_image')) {
            $imageName2 = time() . '-' . uniqid() . '.' . $panelimage1->getClientOriginalExtension();
            $panelimage1->move(public_path('podiumfeature'), $imageName2);
        }

        $feature->title_id = $request->title_id;
        $feature->description = $request->description;
        $feature->background_image = $imageName2;

        $feature->save();

        if ($feature->save()) {
            $data = [
                'status' => true,
                'message' => 'Feature successfully created',
                'data' => $feature,
            ];
            return response()->json($data, 201);
        } else {
            $data = [
                'status' => false,
                'message' => 'Error occurred',
                'data' => [],
            ];
            return response()->json($data, 501);
        }
    }

    public function updatePodiumFeature(Request $request, $id)
    {
        $feature = PodiumFeature::find($id);
        if (!$feature) {
            return response()->json([
                'status' => false,
                'message' => 'Podium feature not found',
            ], 404);
        }

        if ($image1 = $request->file('background_image')) {
            if ($feature->background_image && file_exists(public_path('podiumfeature') . '/' . $feature->background_image)) {
                unlink(public_path('podiumfeature') . '/' . $feature->background_image);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('podiumfeature'), $imageName1);

            $feature->background_image = $imageName1;
        }

        $feature->title_id = $request->title_id;
        $feature->description = $request->description;
        $feature->is_active = $request->is_active;
        $feature->save();

        $all_data = [
            'description' => $feature->description,
            'background_image' => $feature->background_image,
            'is_active' => $feature->is_active
        ];

        $data = [
            'status' => 200,
            'message' => "Podium features updated successfully",
            'title_id' => $feature->title->name,
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function detailsPodiumFeature()
    {
        $data = PodiumFeature::where('is_active', true)->first();
        $title = $data->title->name;
        $data = [
            'status' => true,
            'message' => 'Here podium feature details:',
            'title' => $title,
            'data' => $data,

        ];
        return response()->json($data, 200);
    }

    public function infoPodiumFeature()
    {
        $data = PodiumFeature::first();
        $title = $data->title->name;
        $data = [
            'status' => true,
            'message' => 'Here podium feature details:',
            'title' => $title,
            'data' => $data,

        ];
        return response()->json($data, 200);
    }

    //Presentation
    public function createPodiumPresentation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_id' => 'required',
            'subtitle_id' => 'required',
            'image_one' => 'required',
            'image_two' => 'required',
            'image_three' => 'required',
            'name' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors(),
            ], 400);
        }  
        
        if ($request->input('title_id') != 21) {
            return response()->json([
                'status' => false,
                'message' => 'Podium can only be created with title equal to 21',
                'data' => [],
            ], 400);
        }

        $wirelessdevice = PodiumPresentation::where('name', $request->input('name'))->first();
        if ($wirelessdevice) {
            return response()->json([
                'status' => false,
                'message' => 'Same name already exists.',
                'data' => [],
            ], 409);
        }

        $podium = new PodiumPresentation();
        if ($panelimage = $request->file('image_one')) {
            $imageName1 = time() . '-' . uniqid() . '.' . $panelimage->getClientOriginalExtension();
            $panelimage->move(public_path('podium_presentation'), $imageName1);
        }
        if ($panelimage1 = $request->file('image_two')) {
            $imageName2 = time() . '-' . uniqid() . '.' . $panelimage1->getClientOriginalExtension();
            $panelimage1->move(public_path('podium_presentation'), $imageName2);
        }
        if ($panelimage2 = $request->file('image_three')) {
            $imageName3 = time() . '-' . uniqid() . '.' . $panelimage2->getClientOriginalExtension();
            $panelimage2->move(public_path('podium_presentation'), $imageName3);
        }

        $presentation = new PodiumPresentation();
        $presentation->title_id = $request->input('title_id');
        $presentation->subtitle_id = $request->input('subtitle_id');
        $presentation->image_one = $imageName1;
        $presentation->image_two = $imageName2;
        $presentation->image_three = $imageName3;
        $presentation->name = $request->input('name');
    
        if ($presentation->save()) {
            $data = [
                'status' => true,
                'message' => 'Podium presentation successfully created',
                'data' => $presentation,
            ];
            return response()->json($data, 201);
        } else {
            $data = [
                'status' => false,
                'message' => 'Error occurred',
                'data' => [],
            ];
            return response()->json($data, 500);
        }
    }

    public function updatePodiumPresentation(Request $request)
    {
        $id=$request->id;
        $presentation = PodiumPresentation::find($id);
        if (!$presentation) {
            return response()->json([
                'status' => false,
                'message' => 'presentation prsentation not found',
            ], 404);
        }


        if ($image1 = $request->file('image_one')) {
            if ($presentation->image_one && file_exists(public_path('podium_presentation') . '/' . $presentation->image_one)) {
                unlink(public_path('podium_presentation') . '/' . $presentation->image_one);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('podium_presentation'), $imageName1);

            $presentation->image_one = $imageName1;
        }

        if ($image2 = $request->file('image_two')) {
            if ($presentation->image_two && file_exists(public_path('podium_presentation') . '/' . $presentation->image_two)) {
                unlink(public_path('podium_presentation') . '/' . $presentation->image_two);
            }

            $imageName2 = time() . '-' . uniqid() . '.' . $image2->getClientOriginalExtension();
            $image2->move(public_path('podium_presentation'), $imageName2);

            $presentation->image_two = $imageName2;
        }

        if ($image3 = $request->file('image_three')) {
            if ($presentation->image_three && file_exists(public_path('podium_presentation') . '/' . $presentation->image_three)) {
                unlink(public_path('podium_presentation') . '/' . $presentation->image_three);
            }

            $imageName3 = time() . '-' . uniqid() . '.' . $image3->getClientOriginalExtension();
            $image3->move(public_path('podium_presentation'), $imageName3);

            $presentation->image_three = $imageName3;
        }



        $presentation->title_id = $request->title_id;
        $presentation->subtitle_id = $request->subtitle_id;
        $presentation->name = $request->name;
        $presentation->is_active = $request->is_active;
        $presentation->save();
        $all_data = [
            'subtitle_id' => $presentation->subtitle_id,
            'title_id' => $presentation->title_id,
            'image_one' => $presentation->image_one,
            'image_two' => $presentation->image_two,
            'image_three' => $presentation->image_three,
            'is_active' => $presentation->is_active
        ];

        $data = [
            'status' => 200,
            'message' => "presentation presentation updated successfully",
            'title_id' => $presentation->title->name,
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function podiumPrsentationList()
    {
        $presentations = PodiumPresentation::where('is_active', true)
            ->with(['title', 'subtitle', 'imageOne', 'imageTwo', 'imageThree'])
            ->get();

        $formattedpresentations = [];

        foreach ($presentations as $presentation) {
            $formattedpresentations[] = [
                'name' => $presentation->name,
                'is_active' => $presentation->is_active
            ];
        }

        $titleName = $presentations->first()->title->name;
        $subtitleName = $presentations->first()->subtitle->name;
        $imageIdOne = $presentations->first()->imageOne->image;
        $imageIdTwo = $presentations->first()->imageTwo->image;
        $imageIdThree = $presentations->first()->imageThree->image;

        $data = [
            'status' => true,
            'message' => 'Here are our device items list:',
            'title' => $titleName,
            'sub_title' => $subtitleName,
            'image_one' => $imageIdOne,
            'image_two' => $imageIdTwo,
            'image_three' => $imageIdThree,
            'data' => $formattedpresentations
        ];

        return response()->json($data, 200);
    }

    public function podiumPrsentationInfo()
    {
        $presentations = PodiumPresentation::with(['title', 'subtitle'])
            ->get();

        $formattedpresentations = [];

        foreach ($presentations as $presentation) {
            $formattedpresentations[] = [
                'image_one'=>$presentation->image_one,
                'image_two'=>$presentation->image_two,
                'image_three'=>$presentation->image_three,
                'name' => $presentation->name,
                'is_active' => $presentation->is_active
            ];
        }

        $titleName = $presentations->first()->title->name;
        $subtitleName = $presentations->first()->subtitle->name;

        $data = [
            'status' => true,
            'message' => 'Here are our device items list:',
            'title' => $titleName,
            'sub_title' => $subtitleName,
            'data' => $formattedpresentations
        ];

        return response()->json($data, 200);
    }
}
