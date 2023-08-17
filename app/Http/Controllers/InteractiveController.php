<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\InteractiveSlider;
use App\Models\InteractiveSpecification;
use App\Models\InteractiveVideoLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InteractiveController extends Controller
{

    //Interactive slider

    public function createInteractiveSlider(Request $request)
    {
        $rules = array(
            'title_id' => 'required',
            'subtitle' => 'required',
            'background_image' => 'required',
            'image' => 'required',
            'icon_link' => 'required'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 403);
        }

        if ($request->input('title_id') != 12) {
            return response()->json([
                'status' => false,
                'message' => 'Interactive slider can only be created with title equal to 12',
                'data' => [],
            ], 400);
        }

        $existingsequence = InteractiveSlider::where('title_id', $request->input('title_id'))->first();
        if ($existingsequence) {
            return response()->json([
                'status' => false,
                'message' => 'Interactive slider already existed',
                'data' => [],
            ], 409);
        }

        $index = new InteractiveSlider();
        if ($panelimage = $request->file('background_image')) {
            $imageName1 = time() . '-' . uniqid() . '.' . $panelimage->getClientOriginalExtension();
            $panelimage->move(public_path('Interactive slider'), $imageName1);
        }

        if ($panelimage1 = $request->file('image')) {
            $imageName2 = time() . '-' . uniqid() . '.' . $panelimage1->getClientOriginalExtension();
            $panelimage1->move(public_path('Interactive slider'), $imageName2);
        }

        $index->title_id = $request->title_id;
        $index->background_image = $imageName1;
        $index->image = $imageName2;
        $index->subtitle = $request->subtitle;
        $index->icon_link = $request->icon_link;
        $index->save();

        if ($index->save()) {
            $data = [
                'status' => true,
                'message' => 'Interactive Slider successfully created',
                'data' => $index,
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

    public function updateInteractiveSlider(Request $request, $id)
    {
        $index = InteractiveSlider::find($id);
        if (!$index) {
            return response()->json([
                'status' => false,
                'message' => 'InteractiveSlider not found',
            ], 404);
        }

        if ($image1 = $request->file('background_image')) {
            if ($index->background_image && file_exists(public_path('Interactive slider') . '/' . $index->background_image)) {
                unlink(public_path('Interactive slider') . '/' . $index->background_image);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('Interactive slider'), $imageName1);

            $index->update([
                'background_image' => $imageName1,
            ]);
        }

        if ($image2 = $request->file('image')) {
            if ($index->image && file_exists(public_path('Interactive slider') . '/' . $index->image)) {
                unlink(public_path('Interactive slider') . '/' . $index->image);
            }

            $imageName2 = time() . '-' . uniqid() . '.' . $image2->getClientOriginalExtension();
            $image2->move(public_path('Interactive slider'), $imageName2);

            $index->update([
                'image' => $imageName2,
            ]);
        }

        $index->update([
            'title_id' => $request->title_id,
            'subtitle' => $request->subtitle,
            'icon_link' => $request->icon_link,
            'isActive' => $request->isActive
        ]);

        $all_data = [
            'title_id' => $index->title_id,
            'subtitle' => $index->subtitle,
            'icon_link' => $index->icon_link,
            'isActive' => $index->isActive
        ];

        $data = [
            'status' => 200,
            'message' => "Interactive Slider updated successfully",
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function InteractiveSliderDetails()
    {
        $pro = InteractiveSlider::where('isActive', true)->first();

        $data = [
            'status' => true,
            'message' => 'Here about InteractiveSlider',
            'title' => $pro->title->name,
            'data' => $pro,

        ];
        return response()->json($data, 200);
    }

    //device 
    public function createDevice(Request $request)
    {
        $rules = array(
            'title_id' => 'required',
            'subtitle_id' => 'required',
            'image_id' => 'required',
            'name' => 'required'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 403);
        }

        if ($request->input('title_id') != 13) {
            return response()->json([
                'status' => false,
                'message' => 'Device can only be created with title equal to 13',
                'data' => [],
            ], 400);
        }

        $index = new Device();
        $index->title_id = $request->title_id;
        $index->subtitle_id = $request->subtitle_id;
        $index->image_id = $request->image_id;
        $index->name = $request->name;
        $index->save();

        if ($index->save()) {
            $data = [
                'status' => true,
                'message' => 'Device successfully created',
                'data' => $index,
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

    public function updateDevice(Request $request, $id)
    {
        $index = Device::find($id);
        if (!$index) {
            return response()->json([
                'status' => false,
                'message' => 'Device items not found',
            ], 404);
        }

        if ($image1 = $request->file('image_id')) {
            if ($index->image_id && file_exists(public_path('Device items') . '/' . $index->image_id)) {
                unlink(public_path('Device items') . '/' . $index->image_id);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('Device items'), $imageName1);

            $index->update([
                'image_id' => $imageName1,
            ]);
        }

        $index->update([
            'title_id' => $request->title_id,
            'subtitle_id' => $request->subtitle_id,
            'name' => $request->name,
            'isActive' => $request->isActive
        ]);

        $all_data = [
            'title_id' => $index->title->name,
            'subtitle' => $index->subtitle->name,
            'image' => $index->deviceimage->image,
            'name' => $index->name,
            'icon_link' => $index->icon_link,
            'isActive' => $index->isActive
        ];

        $data = [
            'status' => 200,
            'message' => "Device updated successfully",
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function deviceItems()
    {
        $cases = Device::where('isActive', true)
            ->select(['title_id', 'subtitle_id', 'name', 'image_id', 'isActive'])
            ->get();

        $formattedcase = [];

        foreach ($cases as $case) {
            $formattedcase[] = [
                'name' => $case->name,
                'isActive' => $case->isActive
            ];
        }

        $title_id = $cases->first()->title->name;
        $subtitle = $cases->first()->subtitle->name;
        $image_id = $cases->first()->deviceimage->image;
        $data = [
            'status' => true,
            'message' => 'Here are our device items list:',
            'title' => $title_id,
            'sub_tilte' => $subtitle,
            'image' => $image_id,
            'data' => $formattedcase
        ];

        return response()->json($data, 200);
    }

    //Specifications
    public function createInteractiveSpecification(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'title_id' => 'required',
            'feature' => 'required',
            'inch_86_ifp' => 'required',
            'inch_75_ifp' => 'required',
            'inch_65_ifp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 403);
        }

        if ($request->input('title_id') != 14) {
            return response()->json([
                'status' => false,
                'message' => 'Specification can only be created with title equal to 14',
                'data' => [],
            ], 400);
        }

        $device = new InteractiveSpecification();
        $device->title_id = $request->input('title_id');
        $device->feature = $request->input('feature');
        $device->inch_86_ifp = $request->input('inch_86_ifp');
        $device->inch_75_ifp = $request->input('inch_75_ifp');
        $device->inch_65_ifp = $request->input('inch_65_ifp');
        $device->save();


        if ($device->save()) {
            $data = [
                'status' => true,
                'message' => 'Device specification successfully created',
                'data' => $device,
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

    public function updateInteractiveSpecification(Request $request, $id)
    {
        $index = InteractiveSpecification::find($id);
        if (!$index) {
            return response()->json([
                'status' => false,
                'message' => 'Specifications items not found',
            ], 404);
        }

        $index->update([
            'title_id' => $request->title_id,
            'feature' => $request->feature,
            'inch_86_ifp' => $request->inch_86_ifp,
            'inch_75_ifp' => $request->inch_75_ifp,
            'inch_65_ifp' => $request->inch_65_ifp,
            'isActive' => $request->isActive
        ]);

        $all_data = [
            'title_id' => $index->title->name,
            'feature' => $index->feature,
            'inch_86_ifp' => $index->inch_86_ifp,
            'inch_75_ifp' => $index->inch_75_ifp,
            'inch_65_ifp' => $index->inch_65_ifp,
            'isActive' => $index->isActive
        ];

        $data = [
            'status' => 200,
            'message' => "Specifications updated successfully",
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function listOfInteractiveSpecification()
    {
        $cases = InteractiveSpecification::where('isActive', true)
            ->select(['title_id', 'feature', 'inch_86_ifp', 'inch_75_ifp', 'inch_65_ifp', 'isActive'])
            ->get();

        $formattedcase = [];

        foreach ($cases as $case) {
            $formattedcase[] = [
                'feature' => $case->feature,
                'inch_86_ifp' => $case->inch_86_ifp,
                'inch_75_ifp' => $case->inch_75_ifp,
                'inch_65_ifp' => $case->inch_65_ifp,
                'isActive' => $case->isActive
            ];
        }

        $title_id = $cases->first()->title->name;
        $data = [
            'status' => true,
            'message' => 'Here are our InteractiveSpecification list:',
            'title' => $title_id,
            'data' => $formattedcase
        ];

        return response()->json($data, 200);
    }

    //video links
    public function addVideoLink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'link' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 403);
        }

        $existingPanel = InteractiveVideoLink::where('link', $request->input('link'))->first();
        if ($existingPanel) {
            return response()->json([
                'status' => false,
                'message' => 'Video link with the same title_id already exists',
                'data' => [],
            ], 409);
        }

        $video = new InteractiveVideoLink();
        $video->link = $request->input('link');
        $video->save();


        if ($video->save()) {
            $data = [
                'status' => true,
                'message' => 'Video link successfully created',
                'data' => $video,
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

    public function updateVideoLink(Request $request, $id)
    {
        $video = InteractiveVideoLink::find($id);
        if (!$video) {
            return response()->json([
                'status' => false,
                'message' => 'Video links not found',
            ], 404);
        }

        $video->update([
            'link' => $request->link,
            'isActive'=>$request->isActive
        ]);

        $all_data = [
            'link' => $video->link,
            'isActive'=>$video->isActive
        ];

        $data = [
            'status' => 200,
            'message' => "Video link updated successfully",
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function videoLinkDetails(){
        $data = InteractiveVideoLink::where('isActive', true)->first();

        $data = [
            'status' => true,
            'message' => 'Here video details',
            'data' => $data,

        ];
        return response()->json($data, 200);
    }
}
