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
            'isActive' => $request->isActive,
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
            'isActive' => $Podium->isActive,
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
        $data = PodiumIntroduction::where('isActive', true)->first();

        $data = [
            'status' => true,
            'message' => 'Here podium introduction details:',
            'title' => $data->title->name,
            'data' => $data,

        ];
        return response()->json($data, 200);
    }

    //Podium
    public function createPodium(Request $request)
    {
        $rules = array(
            'title_id' => 'required',
            'description' => 'required',
            'background_image' => 'required',
            'image' => 'required'

        );

        $validator = Validator::make($request->all(), $rules);

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
            if ($podium->image && file_exists(public_path('Podium') . '/' . $podium->image)) {
                unlink(public_path('Podium') . '/' . $podium->image);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('Podium'), $imageName1);

            $podium->image = $imageName1;
        }

        if ($image2 = $request->file('background_image')) {
            if ($podium->background_image && file_exists(public_path('Podium') . '/' . $podium->background_image)) {
                unlink(public_path('Podium') . '/' . $podium->background_image);
            }

            $imageName2 = time() . '-' . uniqid() . '.' . $image2->getClientOriginalExtension();
            $image2->move(public_path('Podium'), $imageName2);

            $podium->background_image = $imageName2;
        }

        $podium->title_id = $request->title_id;
        $podium->description = $request->description;
        $podium->isActive = $request->isActive;
        $podium->save();

        $all_data = [
            'description' => $podium->description,
            'image' => $podium->image,
            'background_image' => $podium->background_image,
            'isActive' => $podium->isActive
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
        $data = Podium::where('isActive', true)->first();

        $data = [
            'status' => true,
            'message' => 'Here podium details:',
            'title' => $data->title->name,
            'data' => $data,

        ];
        return response()->json($data, 200);
    }

    //Screen share
    public function createScreenShare(Request $request)
    {
        $rules = array(
            'title_id' => 'required',
            'description' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);

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


        $podium = new ScreenShare();
        $podium->title_id = $request->title_id;
        $podium->description = $request->description;
        $podium->save();

        if ($podium->save()) {
            $data = [
                'status' => true,
                'message' => 'Screen share successfully created',
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

    public function updateScreenShare(Request $request, $id)
    {
        $Podium = ScreenShare::find($id);
        if (!$Podium) {
            return response()->json([
                'status' => false,
                'message' => 'Screen share not found',
            ], 404);
        }

        $Podium->update([
            'title_id' => $request->title_id,
            'description' => $request->description,
            'isActive' => $request->isActive,
        ]);

        $all_data = [
            'title_id' => $Podium->title_id,
            'description' => $Podium->description,
            'isActive' => $Podium->isActive,
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
        $data = ScreenShare::where('isActive', true)->first();

        $data = [
            'status' => true,
            'message' => 'Here screen share details:',
            'title' => $data->title->name,
            'data' => $data,

        ];
        return response()->json($data, 200);
    }

    //Wireless device
    public function createWirelessDevice(Request $request)
    {
        $rules = array(
            'title_id' => 'required',
            'image_one' => 'required',
            'image_two' => 'required',
            'image_three' => 'required'

        );

        $validator = Validator::make($request->all(), $rules);

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

        $existingPanel = WirelessDevice::where('title_id', $request->input('title_id'))->first();
        if ($existingPanel) {
            return response()->json([
                'status' => false,
                'message' => 'Wireless device with the same title_id already exists',
                'data' => [],
            ], 409);
        }


        $podium = new WirelessDevice();
        if ($panelimage = $request->file('image_one')) {
            $imageName1 = time() . '-' . uniqid() . '.' . $panelimage->getClientOriginalExtension();
            $panelimage->move(public_path('Wireless device'), $imageName1);
        }

        if ($panelimage1 = $request->file('image_two')) {
            $imageName2 = time() . '-' . uniqid() . '.' . $panelimage1->getClientOriginalExtension();
            $panelimage1->move(public_path('Wireless device'), $imageName2);
        }

        if ($panelimage2 = $request->file('image_three')) {
            $imageName3 = time() . '-' . uniqid() . '.' . $panelimage2->getClientOriginalExtension();
            $panelimage2->move(public_path('Wireless device'), $imageName3);
        }

        $podium->title_id = $request->title_id;
        $podium->image_one = $imageName1;
        $podium->image_two = $imageName2;
        $podium->image_three = $imageName3;
        $podium->save();

        if ($podium->save()) {
            $data = [
                'status' => true,
                'message' => 'Wireless device successfully created',
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

    public function updateWirelessDevice(Request $request, $id)
    {
        $podium = WirelessDevice::find($id);
        if (!$podium) {
            return response()->json([
                'status' => false,
                'message' => 'Wireless device not found',
            ], 404);
        }

        if ($image1 = $request->file('image_one')) {
            if ($podium->image_one && file_exists(public_path('Wireless device') . '/' . $podium->image_one)) {
                unlink(public_path('Wireless device') . '/' . $podium->image_one);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('Wireless device'), $imageName1);

            $podium->image_one = $imageName1;
        }

        if ($image2 = $request->file('image_two')) {
            if ($podium->image_two && file_exists(public_path('Wireless device') . '/' . $podium->image_two)) {
                unlink(public_path('Wireless device') . '/' . $podium->image_two);
            }

            $imageName2 = time() . '-' . uniqid() . '.' . $image2->getClientOriginalExtension();
            $image2->move(public_path('Wireless device'), $imageName2);

            $podium->image_two = $imageName2;
        }

        if ($image3 = $request->file('image_three')) {
            if ($podium->image_three && file_exists(public_path('Wireless device') . '/' . $podium->image_three)) {
                unlink(public_path('Wireless device') . '/' . $podium->image_three);
            }

            $imageName3 = time() . '-' . uniqid() . '.' . $image3->getClientOriginalExtension();
            $image3->move(public_path('Wireless device'), $imageName3);

            $podium->image_three = $imageName3;
        }

        $podium->title_id = $request->title_id;
        $podium->isActive = $request->isActive;
        $podium->save();

        $all_data = [
            'description' => $podium->description,
            'image_one' => $podium->image_one,
            'image_two' => $podium->image_two,
            'image_three' => $podium->image_three
        ];

        $data = [
            'status' => 200,
            'message' => "Wireless device updated successfully",
            'title_id' => $podium->title->name,
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function wirelessDeviceDetails()
    {
        $data = WirelessDevice::where('isActive', true)->first();

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


        $podium = new Anotation();
        if ($panelimage = $request->file('background_image')) {
            $imageName1 = time() . '-' . uniqid() . '.' . $panelimage->getClientOriginalExtension();
            $panelimage->move(public_path('Anotation'), $imageName1);
        }


        $podium->title_id = $request->title_id;
        $podium->background_image = $imageName1;
        $podium->sub_title = $request->sub_title;
        $podium->field_one = $request->field_one;
        $podium->field_two = $request->field_two;
        $podium->field_three = $request->field_three;
        $podium->save();

        if ($podium->save()) {
            $data = [
                'status' => true,
                'message' => 'Anotation device successfully created',
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

    public function updateAnnotation(Request $request, $id)
    {
        $podium = Anotation::find($id);
        if (!$podium) {
            return response()->json([
                'status' => false,
                'message' => 'Anotation not found',
            ], 404);
        }

        if ($image1 = $request->file('background_image')) {
            if ($podium->background_image && file_exists(public_path('Anotation') . '/' . $podium->background_image)) {
                unlink(public_path('Anotation') . '/' . $podium->background_image);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('Anotation'), $imageName1);

            $podium->background_image = $imageName1;
        }

        $podium->title_id = $request->title_id;
        $podium->sub_title = $request->sub_title;
        $podium->field_one = $request->field_one;
        $podium->field_two = $request->field_two;
        $podium->field_three = $request->field_three;
        $podium->isActive = $request->isActive;
        $podium->save();

        $all_data = [
            'sub_title' => $podium->sub_title,
            'field_one' => $podium->field_one,
            'field_two' => $podium->field_two,
            'field_three' => $podium->field_three,
            'background_image' => $podium->background_image,
            'isActive' => $podium->isActive
        ];

        $data = [
            'status' => 200,
            'message' => "Anotation updated successfully",
            'title_id' => $podium->title->name,
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function anotationDetails()
    {
        $data = Anotation::where('isActive', true)->first();
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

        $podium = new PodiumFeature();
        if ($panelimage1 = $request->file('background_image')) {
            $imageName2 = time() . '-' . uniqid() . '.' . $panelimage1->getClientOriginalExtension();
            $panelimage1->move(public_path('Podium feature'), $imageName2);
        }

        $podium->title_id = $request->title_id;
        $podium->description = $request->description;
        $podium->background_image = $imageName2;

        $podium->save();

        if ($podium->save()) {
            $data = [
                'status' => true,
                'message' => 'Podium feature successfully created',
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

    public function updatePodiumFeature(Request $request, $id)
    {
        $podium = PodiumFeature::find($id);
        if (!$podium) {
            return response()->json([
                'status' => false,
                'message' => 'Podium feature not found',
            ], 404);
        }

        if ($image1 = $request->file('background_image')) {
            if ($podium->background_image && file_exists(public_path('Podium feature') . '/' . $podium->background_image)) {
                unlink(public_path('Podium feature') . '/' . $podium->background_image);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('Podium feature'), $imageName1);

            $podium->background_image = $imageName1;
        }

        $podium->title_id = $request->title_id;
        $podium->description = $request->description;
        $podium->isActive = $request->isActive;
        $podium->save();

        $all_data = [
            'description' => $podium->description,
            'background_image' => $podium->background_image,
            'isActive' => $podium->isActive
        ];

        $data = [
            'status' => 200,
            'message' => "Podium features updated successfully",
            'title_id' => $podium->title->name,
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function detailsPodiumFeature()
    {
        $data = PodiumFeature::where('isActive', true)->first();
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
            'image_id_one' => 'required',
            'image_id_two' => 'required',
            'image_id_three' => 'required',
            'name' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors(),
            ], 400);
        }
    
        $existingPodium = PodiumPresentation::where('name', $request->input('name'))
            ->first();
    
        if ($existingPodium) {
            return response()->json([
                'status' => false,
                'message' => 'Podium presentation with the same title_id and subtitle_id already exists',
                'data' => [],
            ], 409);
        }
    
        $podium = new PodiumPresentation();
        $podium->title_id = $request->input('title_id');
        $podium->subtitle_id = $request->input('subtitle_id');
        $podium->image_id_one = $request->input('image_id_one');
        $podium->image_id_two = $request->input('image_id_two');
        $podium->image_id_three = $request->input('image_id_three');
        $podium->name = $request->input('name');
    
        if ($podium->save()) {
            $data = [
                'status' => true,
                'message' => 'Podium presentation successfully created',
                'data' => $podium,
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

    public function updatePodiumPresentation(Request $request, $id)
    {
        $podium = PodiumPresentation::find($id);
        if (!$podium) {
            return response()->json([
                'status' => false,
                'message' => 'Podium prsentation not found',
            ], 404);
        }
        $podium->title_id = $request->title_id;
        $podium->subtitle_id = $request->subtitle_id;
        $podium->image_id_one = $request->image_id_one;
        $podium->image_id_two = $request->image_id_two;
        $podium->image_id_three = $request->image_id_three;
        $podium->name=$request->name;
        $podium->isActive = $request->isActive;
        $podium->save();
        $all_data = [
            'subtitle_id' => $podium->subtitle_id,
            'title_id' => $podium->title_id,
            'image_id_one' => $podium->image_id_one,
            'image_id_two' => $podium->image_id_two,
            'image_id_three' => $podium->image_id_three,
            'isActive' => $podium->isActive
        ];

        $data = [
            'status' => 200,
            'message' => "Podium presentation updated successfully",
            'title_id' => $podium->title->name,
            'data' => $all_data,
        ];

        return response()->json($data);
    }
    
    public function podiumPrsentationList()
    {
        $cases = PodiumPresentation::where('isActive', true)
            ->with(['title', 'subtitle', 'imageOne', 'imageTwo', 'imageThree'])
            ->get();
    
        $formattedCases = [];
    
        foreach ($cases as $case) {
            $formattedCases[] = [
                'name' => $case->name,
                'isActive' => $case->isActive
            ];
        }
    
        $titleName = $cases->first()->title->name;
        $subtitleName = $cases->first()->subtitle->name;
        $imageIdOne = $cases->first()->imageOne->image;
        $imageIdTwo = $cases->first()->imageTwo->image;
        $imageIdThree = $cases->first()->imageThree->image;
    
        $data = [
            'status' => true,
            'message' => 'Here are our device items list:',
            'title' => $titleName,
            'sub_title' => $subtitleName,
            'image_one' => $imageIdOne,
            'image_two' => $imageIdTwo,
            'image_three' => $imageIdThree,
            'data' => $formattedCases
        ];
    
        return response()->json($data, 200);
    }
    
    
}
