<?php

namespace App\Http\Controllers;

use App\Models\Signage;
use App\Models\SignageIntroduction;
use App\Models\SignageSlider;
use App\Models\SignageSpecification;
use App\Models\SignageVideoLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SignageController extends Controller
{
    //signage introduction
    public function createSignageIntroduction(Request $request)
    {
        $rules = array(
            'title_id' => 'required',
            'header' => 'required',
            'image' => 'required',
            'background_image' => 'required',
            'header_link' => 'required'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 403);
        }

        if ($request->input('title_id') != 22) {
            return response()->json([
                'status' => false,
                'message' => 'Header introductoin can only be created with title equal to 22',
                'data' => [],
            ], 400);
        }

        $existingsequence = SignageIntroduction::where('title_id', $request->input('title_id'))->first();
        if ($existingsequence) {
            return response()->json([
                'status' => false,
                'message' => 'Signage introduction already existed',
                'data' => [],
            ], 409);
        }

        $signage = new SignageIntroduction();
        if ($panelimage = $request->file('background_image')) {
            $imageName1 = time() . '-' . uniqid() . '.' . $panelimage->getClientOriginalExtension();
            $panelimage->move(public_path('Signage intro'), $imageName1);
        }

        if ($panelimage1 = $request->file('image')) {
            $imageName2 = time() . '-' . uniqid() . '.' . $panelimage1->getClientOriginalExtension();
            $panelimage1->move(public_path('Signage intro'), $imageName2);
        }

        $signage->title_id = $request->title_id;
        $signage->background_image = $imageName1;
        $signage->image = $imageName2;
        $signage->header = $request->header;
        $signage->header_link = $request->header_link;
        $signage->save();

        if ($signage->save()) {
            $data = [
                'status' => true,
                'message' => 'Signage introduction successfully created',
                'data' => $signage,
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

    public function updateSignageIntroduction(Request $request, $id)
    {
        $signage = SignageIntroduction::find($id);
        if (!$signage) {
            return response()->json([
                'status' => false,
                'message' => 'Signage introduction not found',
            ], 404);
        }

        if ($image1 = $request->file('background_image')) {
            if ($signage->background_image && file_exists(public_path('Signage intro') . '/' . $signage->background_image)) {
                unlink(public_path('Signage intro') . '/' . $signage->background_image);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('Signage intro'), $imageName1);

            $signage->update([
                'background_image' => $imageName1,
            ]);
        }

        if ($image2 = $request->file('image')) {
            if ($signage->image && file_exists(public_path('Signage intro') . '/' . $signage->image)) {
                unlink(public_path('Signage intro') . '/' . $signage->image);
            }

            $imageName2 = time() . '-' . uniqid() . '.' . $image2->getClientOriginalExtension();
            $image2->move(public_path('Signage intro'), $imageName2);

            $signage->update([
                'image' => $imageName2,
            ]);
        }

        $signage->update([
            'title_id' => $request->title_id,
            'header' => $request->header,
            'header_link' => $request->header_link,
            'isActive' => $request->isActive
        ]);

        $all_data = [
            'title_id' => $signage->title_id,
            'header' => $signage->header,
            'header_link' => $signage->header_link,
            'isActive' => $signage->isActive
        ];

        $data = [
            'status' => 200,
            'message' => "Signage introduction updated successfully",
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function signageIntroductionDetails()
    {
        $data = SignageIntroduction::where('isActive', true)->first();

        $data = [
            'status' => true,
            'message' => 'Here signage introduction details:',
            'title' => $data->title->name,
            'data' => $data,

        ];
        return response()->json($data, 200);
    }

    //signage
    public function createSignage(Request $request)
    {
        $rules = array(
            'title_id' => 'required',
            'name' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 403);
        }

        if ($request->input('title_id') != 22) {
            return response()->json([
                'status' => false,
                'message' => 'Signage can only be created with title equal to 22',
                'data' => [],
            ], 400);
        }

        $existingsequence = Signage::where('name', $request->input('name'))->first();
        if ($existingsequence) {
            return response()->json([
                'status' => false,
                'message' => 'Signage items already existed',
                'data' => [],
            ], 409);
        }

        $signage = new Signage();
        $signage->title_id = $request->title_id;
        $signage->name = $request->name;
        $signage->save();

        if ($signage->save()) {
            $data = [
                'status' => true,
                'message' => 'Signage introduction successfully created',
                'data' => $signage,
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

    public function updateSignageItems(Request $request, $id)
    {
        $signage = Signage::find($id);
        if (!$signage) {
            return response()->json([
                'status' => false,
                'message' => 'Signage item not found',
            ], 404);
        }

        $signage->title_id = $request->title_id;
        $signage->name = $request->name;
        $signage->isActive = $request->isActive;
        $signage->save();

        $all_data = [
            'name' => $signage->name,
            'isActive' => $signage->isActive
        ];

        $data = [
            'status' => 200,
            'message' => "Signage item updated successfully",
            'title_id' => $signage->title->name,
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function signageDetails()
    {
        $signages = Signage::where('isActive', true)
            ->get();

        $formattedsignages = [];

        foreach ($signages as $signage) {
            $formattedsignages[] = [
                'name' => $signage->name,
                'isActive' => $signage->isActive
            ];
        }

        $titleName = $signages->first()->title->name;
        $description = $signage->first()->title->description;

        $data = [
            'status' => true,
            'message' => 'Here are our signage items list:',
            'title' => $titleName,
            'description' => $description,
            'data' => $formattedsignages
        ];

        return response()->json($data, 200);
    }

    //Signage slider
    public function createSignageSlider(Request $request)
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

        if ($request->input('title_id') != 23) {
            return response()->json([
                'status' => false,
                'message' => 'Slider can only be created with title equal to 23',
                'data' => [],
            ], 400);
        }

        $existingPanel = SignageSlider::where('title_id', $request->input('title_id'))->first();
        if ($existingPanel) {
            return response()->json([
                'status' => false,
                'message' => 'signage slider with the same title_id already exists',
                'data' => [],
            ], 409);
        }

        $signage = new SignageSlider();
        if ($panelimage = $request->file('image_one')) {
            $imageName1 = time() . '-' . uniqid() . '.' . $panelimage->getClientOriginalExtension();
            $panelimage->move(public_path('Signage slide'), $imageName1);
        }

        if ($panelimage1 = $request->file('image_two')) {
            $imageName2 = time() . '-' . uniqid() . '.' . $panelimage1->getClientOriginalExtension();
            $panelimage1->move(public_path('Signage slide'), $imageName2);
        }

        if ($panelimage2 = $request->file('image_three')) {
            $imageName3 = time() . '-' . uniqid() . '.' . $panelimage2->getClientOriginalExtension();
            $panelimage2->move(public_path('Signage slide'), $imageName3);
        }

        $signage->title_id = $request->title_id;
        $signage->image_one = $imageName1;
        $signage->image_two = $imageName2;
        $signage->image_three = $imageName3;
        $signage->save();

        if ($signage->save()) {
            $data = [
                'status' => true,
                'message' => 'Signage slider successfully created',
                'data' => $signage,
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

    public function updateSignageSlider(Request $request, $id)
    {
        $signage = SignageSlider::find($id);
        if (!$signage) {
            return response()->json([
                'status' => false,
                'message' => 'Signage sliders image not found',
            ], 404);
        }

        if ($image1 = $request->file('image_one')) {
            if ($signage->image_one && file_exists(public_path('Signage slide') . '/' . $signage->image_one)) {
                unlink(public_path('Signage slide') . '/' . $signage->image_one);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('Signage slide'), $imageName1);

            $signage->image_one = $imageName1;
        }

        if ($image2 = $request->file('image_two')) {
            if ($signage->image_two && file_exists(public_path('Signage slide') . '/' . $signage->image_two)) {
                unlink(public_path('Signage slide') . '/' . $signage->image_two);
            }

            $imageName2 = time() . '-' . uniqid() . '.' . $image2->getClientOriginalExtension();
            $image2->move(public_path('Signage slide'), $imageName2);

            $signage->image_two = $imageName2;
        }

        if ($image3 = $request->file('image_three')) {
            if ($signage->image_three && file_exists(public_path('Signage slide') . '/' . $signage->image_three)) {
                unlink(public_path('Signage slide') . '/' . $signage->image_three);
            }

            $imageName3 = time() . '-' . uniqid() . '.' . $image3->getClientOriginalExtension();
            $image3->move(public_path('Signage slide'), $imageName3);

            $signage->image_three = $imageName3;
        }



        $signage->title_id = $request->title_id;
        $signage->isActive = $request->isActive;
        $signage->save();

        $all_data = [
            'image_one' => $signage->image_one,
            'image_two' => $signage->image_two,
            'image_three' => $signage->image_three,
            'isActive' => $signage->isActive
        ];

        $data = [
            'status' => 200,
            'message' => "sitgange slider image successfully",
            'title_id' => $signage->title->name,
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function detailsOfSlignageSlider()
    {
        $data = SignageSlider::where('isActive', true)->first();

        $data = [
            'status' => true,
            'message' => 'Here signage slider details:',
            'title' => $data->title->name,
            'data' => $data,

        ];
        return response()->json($data, 200);
    }

    //specifications
    public function createSignageSpecification(Request $request)
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

        if ($request->input('title_id') != 24) {
            return response()->json([
                'status' => false,
                'message' => 'Specification can only be created with title equal to 24',
                'data' => [],
            ], 400);
        }

        $signage = new SignageSpecification();
        $signage->title_id = $request->input('title_id');
        $signage->feature = $request->input('feature');
        $signage->inch_86_ifp = $request->input('inch_86_ifp');
        $signage->inch_75_ifp = $request->input('inch_75_ifp');
        $signage->inch_65_ifp = $request->input('inch_65_ifp');
        $signage->save();


        if ($signage->save()) {
            $data = [
                'status' => true,
                'message' => 'Signage specification successfully created',
                'data' => $signage,
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

    public function updateSignageSpecification(Request $request, $id)
    {
        $signage = SignageSpecification::find($id);
        if (!$signage) {
            return response()->json([
                'status' => false,
                'message' => 'Signage items not found',
            ], 404);
        }

        $signage->update([
            'title_id' => $request->title_id,
            'feature' => $request->feature,
            'inch_86_ifp' => $request->inch_86_ifp,
            'inch_75_ifp' => $request->inch_75_ifp,
            'inch_65_ifp' => $request->inch_65_ifp,
            'isActive' => $request->isActive
        ]);

        $all_data = [
            'title_id' => $signage->title->name,
            'feature' => $signage->feature,
            'inch_86_ifp' => $signage->inch_86_ifp,
            'inch_75_ifp' => $signage->inch_75_ifp,
            'inch_65_ifp' => $signage->inch_65_ifp,
            'isActive' => $signage->isActive
        ];

        $data = [
            'status' => 200,
            'message' => "Signage specification updated successfully",
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function listOfSignageSpecification()
    {
        $signages = SignageSpecification::where('isActive', true)
            ->select(['title_id', 'feature', 'inch_86_ifp', 'inch_75_ifp', 'inch_65_ifp', 'isActive'])
            ->get();

        $formatteditem = [];

        foreach ($signages as $item) {
            $formatteditem[] = [
                'feature' => $item->feature,
                'inch_86_ifp' => $item->inch_86_ifp,
                'inch_75_ifp' => $item->inch_75_ifp,
                'inch_65_ifp' => $item->inch_65_ifp,
                'isActive' => $item->isActive
            ];
        }

        $title_id = $signages->first()->title->name;
        $data = [
            'status' => true,
            'message' => 'Here are our signage specification list:',
            'title' => $title_id,
            'data' => $formatteditem
        ];

        return response()->json($data, 200);
    }

    //video link
    public function addVideoLink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'link_name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 403);
        }

        $existingPanel = SignageVideoLink::where('link_name', $request->input('link_name'))->first();
        if ($existingPanel) {
            return response()->json([
                'status' => false,
                'message' => 'Video link with the same title_id already exists',
                'data' => [],
            ], 409);
        }

        $video = new SignageVideoLink();
        $video->link_name = $request->input('link_name');
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
        $video = SignageVideoLink::find($id);
        if (!$video) {
            return response()->json([
                'status' => false,
                'message' => 'Video links not found',
            ], 404);
        }

        $video->update([
            'link_name' => $request->link_name,
            'isActive' => $request->isActive
        ]);

        $all_data = [
            'link_name' => $video->link_name,
            'isActive' => $video->isActive
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
        $data = SignageVideoLink::where('isActive', true)->first();

        $data = [
            'status' => true,
            'message' => 'Here video details',
            'data' => $data,

        ];
        return response()->json($data, 200);
    }

    
}
