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
        $validator = Validator::make($request->all(), [
            'title_id' => 'required',
            'subtitle' => 'required',
            'background_image' => 'required',
            'image' => 'required',
            'icon_link' => 'required'
        ]);

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

        $slider = new InteractiveSlider();
        if ($panelimage = $request->file('background_image')) {
            $imageName1 = time() . '-' . uniqid() . '.' . $panelimage->getClientOriginalExtension();
            $panelimage->move(public_path('Interactive slider'), $imageName1);
        }

        if ($panelimage1 = $request->file('image')) {
            $imageName2 = time() . '-' . uniqid() . '.' . $panelimage1->getClientOriginalExtension();
            $panelimage1->move(public_path('Interactive slider'), $imageName2);
        }

        $slider->title_id = $request->title_id;
        $slider->background_image = $imageName1;
        $slider->image = $imageName2;
        $slider->subtitle = $request->subtitle;
        $slider->icon_link = $request->icon_link;
        $slider->save();

        if ($slider->save()) {
            $data = [
                'status' => true,
                'message' => 'Interactive Slider successfully created',
                'data' => $slider,
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
        $slider = InteractiveSlider::find($id);
        if (!$slider) {
            return response()->json([
                'status' => false,
                'message' => 'InteractiveSlider not found',
            ], 404);
        }

        if ($image1 = $request->file('background_image')) {
            if ($slider->background_image && file_exists(public_path('Interactive slider') . '/' . $slider->background_image)) {
                unlink(public_path('Interactive slider') . '/' . $slider->background_image);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('Interactive slider'), $imageName1);

            $slider->update([
                'background_image' => $imageName1,
            ]);
        }

        if ($image2 = $request->file('image')) {
            if ($slider->image && file_exists(public_path('Interactive slider') . '/' . $slider->image)) {
                unlink(public_path('Interactive slider') . '/' . $slider->image);
            }

            $imageName2 = time() . '-' . uniqid() . '.' . $image2->getClientOriginalExtension();
            $image2->move(public_path('Interactive slider'), $imageName2);

            $slider->update([
                'image' => $imageName2,
            ]);
        }

        $slider->update([
            'title_id' => $request->title_id,
            'subtitle' => $request->subtitle,
            'icon_link' => $request->icon_link,
            'is_active' => $request->is_active
        ]);

        $all_data = [
            'title_id' => $slider->title_id,
            'subtitle' => $slider->subtitle,
            'icon_link' => $slider->icon_link,
            'is_active' => $slider->is_active
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
        $slider = InteractiveSlider::where('is_active', true)->first();

        $data = [
            'status' => true,
            'message' => 'Here about InteractiveSlider',
            'title' => $slider->title->name,
            'data' => $slider,

        ];
        return response()->json($data, 200);
    }

    public function InteractiveSliderInfo()
    {
        $slider = InteractiveSlider::first();

        if ($slider) {
            $data = [
                'status' => true,
                'message' => 'Here about InteractiveSlider',
                'title' => $slider->title->name,
                'data' => $slider,
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => false,
                'message' => 'Data is not active',
                'data' => $slider,
            ];
            return response()->json($data, 404);
        }
    }

    //device 
    public function createDevice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_id' => 'required',
            'subtitle_id' => 'required',
            'image_id' => 'required',
            'name' => 'required'
        ]);

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

        $device = new Device();
        $device->title_id = $request->title_id;
        $device->subtitle_id = $request->subtitle_id;
        $device->image_id = $request->image_id;
        $device->name = $request->name;
        $device->save();

        if ($device->save()) {
            $data = [
                'status' => true,
                'message' => 'Device successfully created',
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

    public function updateDevice(Request $request, $id)
    {
        $device = Device::find($id);
        if (!$device) {
            return response()->json([
                'status' => false,
                'message' => 'Device items not found',
            ], 404);
        }

        if ($image1 = $request->file('image_id')) {
            if ($device->image_id && file_exists(public_path('Device items') . '/' . $device->image_id)) {
                unlink(public_path('Device items') . '/' . $device->image_id);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('Device items'), $imageName1);

            $device->update([
                'image_id' => $imageName1,
            ]);
        }

        $device->update([
            'title_id' => $request->title_id,
            'subtitle_id' => $request->subtitle_id,
            'name' => $request->name,
            'is_active' => $request->is_active
        ]);

        $all_data = [
            'title_id' => $device->title->name,
            'subtitle' => $device->subtitle->name,
            'image' => $device->deviceimage->image,
            'name' => $device->name,
            'icon_link' => $device->icon_link,
            'is_active' => $device->is_active
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
        $devices = Device::where('is_active', true)
            ->select(['title_id', 'subtitle_id', 'name', 'image_id', 'is_active'])
            ->get();

        $formatteddevice = [];

        foreach ($devices as $device) {
            $formatteddevice[] = [
                'name' => $device->name,
                'is_active' => $device->is_active
            ];
        }

        $title_id = $devices->first()->title->name;
        $subtitle = $devices->first()->subtitle->name;
        $image_id = $devices->first()->deviceimage->image;
        $data = [
            'status' => true,
            'message' => 'Here are our device items list:',
            'title' => $title_id,
            'sub_tilte' => $subtitle,
            'image' => $image_id,
            'data' => $formatteddevice
        ];

        return response()->json($data, 200);
    }

    public function deviceInfo()
    {
        $devices = Device::select(['title_id', 'subtitle_id', 'name', 'image_id', 'is_active'])
            ->get();

        $formatteddevice = [];

        foreach ($devices as $device) {
            $formatteddevice[] = [
                'name' => $device->name,
                'is_active' => $device->is_active
            ];
        }

        $title_id = $devices->first()->title->name;
        $subtitle = $devices->first()->subtitle->name;
        $image_id = $devices->first()->deviceimage->image;
        $data = [
            'status' => true,
            'message' => 'Here are our device items list:',
            'title' => $title_id,
            'sub_tilte' => $subtitle,
            'image' => $image_id,
            'data' => $formatteddevice
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

        $specification = new InteractiveSpecification();
        $specification->title_id = $request->input('title_id');
        $specification->feature = $request->input('feature');
        $specification->inch_86_ifp = $request->input('inch_86_ifp');
        $specification->inch_75_ifp = $request->input('inch_75_ifp');
        $specification->inch_65_ifp = $request->input('inch_65_ifp');
        $specification->save();


        if ($specification->save()) {
            $data = [
                'status' => true,
                'message' => 'specification specification successfully created',
                'data' => $specification,
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
        $specification = InteractiveSpecification::find($id);
        if (!$specification) {
            return response()->json([
                'status' => false,
                'message' => 'Specifications items not found',
            ], 404);
        }

        $specification->update([
            'title_id' => $request->title_id,
            'feature' => $request->feature,
            'inch_86_ifp' => $request->inch_86_ifp,
            'inch_75_ifp' => $request->inch_75_ifp,
            'inch_65_ifp' => $request->inch_65_ifp,
            'is_active' => $request->is_active
        ]);

        $all_data = [
            'title_id' => $specification->title->name,
            'feature' => $specification->feature,
            'inch_86_ifp' => $specification->inch_86_ifp,
            'inch_75_ifp' => $specification->inch_75_ifp,
            'inch_65_ifp' => $specification->inch_65_ifp,
            'is_active' => $specification->is_active
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
        $specifications = InteractiveSpecification::where('is_active', true)
            ->select(['title_id', 'feature', 'inch_86_ifp', 'inch_75_ifp', 'inch_65_ifp', 'is_active'])
            ->get();

        $formattedspecification = [];

        foreach ($specifications as $specification) {
            $formattedspecification[] = [
                'feature' => $specification->feature,
                'inch_86_ifp' => $specification->inch_86_ifp,
                'inch_75_ifp' => $specification->inch_75_ifp,
                'inch_65_ifp' => $specification->inch_65_ifp,
                'is_active' => $specification->is_active
            ];
        }

        $title_id = $specifications->first()->title->name;
        $data = [
            'status' => true,
            'message' => 'Here are our InteractiveSpecification list:',
            'title' => $title_id,
            'data' => $formattedspecification
        ];

        return response()->json($data, 200);
    }

    public function infoOfInteractiveSpecification()
    {
        $specifications = InteractiveSpecification::select(['title_id', 'feature', 'inch_86_ifp', 'inch_75_ifp', 'inch_65_ifp', 'is_active'])
            ->get();

        $formattedspecification = [];

        foreach ($specifications as $specification) {
            $formattedspecification[] = [
                'feature' => $specification->feature,
                'inch_86_ifp' => $specification->inch_86_ifp,
                'inch_75_ifp' => $specification->inch_75_ifp,
                'inch_65_ifp' => $specification->inch_65_ifp,
                'is_active' => $specification->is_active
            ];
        }

        $title_id = $specifications->first()->title->name;
        $data = [
            'status' => true,
            'message' => 'Here are our InteractiveSpecification list:',
            'title' => $title_id,
            'data' => $formattedspecification
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
            'is_active' => $request->is_active
        ]);

        $all_data = [
            'link' => $video->link,
            'is_active' => $video->is_active
        ];

        $data = [
            'status' => 200,
            'message' => "Video link updated successfully",
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function videoLinkDetails()
    {
        $data = InteractiveVideoLink::where('is_active', true)->first();

        $data = [
            'status' => true,
            'message' => 'Here video details',
            'data' => $data,

        ];
        return response()->json($data, 200);
    }

    public function videoLinkInfo()
    {
        $video = InteractiveVideoLink::first();
        if ($video) {

            $data = [
                'status' => true,
                'message' => 'Here video details',
                'data' => $video,

            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => False,
                'message' => 'Link is not active',
                'data' => [],

            ];
            return response()->json($data, 404);
        }
    }
}
