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

        $validator = Validator::make($request->all(), [
            'title_id' => 'required',
            'header' => 'required',
            'image' => 'required',
            'background_image' => 'required',
            'header_link' => 'required'
        ]);

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
            'is_active' => $request->is_active
        ]);

        $all_data = [
            'title_id' => $signage->title_id,
            'header' => $signage->header,
            'header_link' => $signage->header_link,
            'is_active' => $signage->is_active
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
        $data = SignageIntroduction::where('is_active', true)->first();
        if ($data) {
            $data = [
                'status' => true,
                'message' => 'Here signage introduction details:',
                'title' => $data->title->name,
                'data' => $data,

            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => false,
                'message' => 'Data is not active',
                'data' => [],

            ];
            return response()->json($data, 404);
        }
    }

    public function signageIntroductionInfo()
    {
        $data = SignageIntroduction::first();

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
        $validator = Validator::make($request->all(), [
            'title_id' => 'required',
            'name' => 'required',
        ]);

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
        $signage->is_active = $request->is_active;
        $signage->save();

        $all_data = [
            'name' => $signage->name,
            'is_active' => $signage->is_active
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
        $signages = Signage::where('is_active', true)
            ->get();

        $formattedsignages = [];

        foreach ($signages as $signage) {
            $formattedsignages[] = [
                'name' => $signage->name,
                'is_active' => $signage->is_active
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

    public function signageInfo()
    {
        $signages = Signage::get();

        $formattedsignages = [];

        foreach ($signages as $signage) {
            $formattedsignages[] = [
                'name' => $signage->name,
                'is_active' => $signage->is_active
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

        $signageslider = new SignageSlider();
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

        $signageslider->title_id = $request->title_id;
        $signageslider->image_one = $imageName1;
        $signageslider->image_two = $imageName2;
        $signageslider->image_three = $imageName3;
        $signageslider->save();

        if ($signageslider->save()) {
            $data = [
                'status' => true,
                'message' => 'Signage slider successfully created',
                'data' => $signageslider,
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
        $signage_slider = SignageSlider::find($id);
        if (!$signage_slider) {
            return response()->json([
                'status' => false,
                'message' => 'Signage sliders image not found',
            ], 404);
        }

        if ($image1 = $request->file('image_one')) {
            if ($signage_slider->image_one && file_exists(public_path('Signage slide') . '/' . $signage_slider->image_one)) {
                unlink(public_path('Signage slide') . '/' . $signage_slider->image_one);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('Signage slide'), $imageName1);

            $signage_slider->image_one = $imageName1;
        }

        if ($image2 = $request->file('image_two')) {
            if ($signage_slider->image_two && file_exists(public_path('Signage slide') . '/' . $signage_slider->image_two)) {
                unlink(public_path('Signage slide') . '/' . $signage_slider->image_two);
            }

            $imageName2 = time() . '-' . uniqid() . '.' . $image2->getClientOriginalExtension();
            $image2->move(public_path('Signage slide'), $imageName2);

            $signage_slider->image_two = $imageName2;
        }

        if ($image3 = $request->file('image_three')) {
            if ($signage_slider->image_three && file_exists(public_path('Signage slide') . '/' . $signage_slider->image_three)) {
                unlink(public_path('Signage slide') . '/' . $signage_slider->image_three);
            }

            $imageName3 = time() . '-' . uniqid() . '.' . $image3->getClientOriginalExtension();
            $image3->move(public_path('Signage slide'), $imageName3);

            $signage_slider->image_three = $imageName3;
        }



        $signage_slider->title_id = $request->title_id;
        $signage_slider->is_active = $request->is_active;
        $signage_slider->save();

        $all_data = [
            'image_one' => $signage_slider->image_one,
            'image_two' => $signage_slider->image_two,
            'image_three' => $signage_slider->image_three,
            'is_active' => $signage_slider->is_active
        ];

        $data = [
            'status' => 200,
            'message' => "sitgange slider image successfully",
            'title_id' => $signage_slider->title->name,
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function detailsOfSlignageSlider()
    {
        $data = SignageSlider::where('is_active', true)->first();
        if ($data) {
            $data = [
                'status' => true,
                'message' => 'Here signage slider details:',
                'title' => $data->title->name,
                'data' => $data,

            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => false,
                'message' => 'Data is not active',
                'data' => $data,

            ];
            return response()->json($data, 404);
        }
    }

    public function infoOfSlignageSlider()
    {
        $data = SignageSlider::first();

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

        $signage_specification = new SignageSpecification();
        $signage_specification->title_id = $request->input('title_id');
        $signage_specification->feature = $request->input('feature');
        $signage_specification->inch_86_ifp = $request->input('inch_86_ifp');
        $signage_specification->inch_75_ifp = $request->input('inch_75_ifp');
        $signage_specification->inch_65_ifp = $request->input('inch_65_ifp');
        $signage_specification->save();


        if ($signage_specification->save()) {
            $data = [
                'status' => true,
                'message' => 'Signage specification successfully created',
                'data' => $signage_specification,
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
        $signage_specification = SignageSpecification::find($id);
        if (!$signage_specification) {
            return response()->json([
                'status' => false,
                'message' => 'signage_specification items not found',
            ], 404);
        }

        $signage_specification->update([
            'title_id' => $request->title_id,
            'feature' => $request->feature,
            'inch_86_ifp' => $request->inch_86_ifp,
            'inch_75_ifp' => $request->inch_75_ifp,
            'inch_65_ifp' => $request->inch_65_ifp,
            'is_active' => $request->is_active
        ]);

        $all_data = [
            'title_id' => $signage_specification->title->name,
            'feature' => $signage_specification->feature,
            'inch_86_ifp' => $signage_specification->inch_86_ifp,
            'inch_75_ifp' => $signage_specification->inch_75_ifp,
            'inch_65_ifp' => $signage_specification->inch_65_ifp,
            'is_active' => $signage_specification->is_active
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
        $signage_specification = SignageSpecification::where('is_active', true)
            ->select(['title_id', 'feature', 'inch_86_ifp', 'inch_75_ifp', 'inch_65_ifp', 'is_active'])
            ->get();

        $formatteditem = [];

        foreach ($signage_specification as $item) {
            $formatteditem[] = [
                'feature' => $item->feature,
                'inch_86_ifp' => $item->inch_86_ifp,
                'inch_75_ifp' => $item->inch_75_ifp,
                'inch_65_ifp' => $item->inch_65_ifp,
                'is_active' => $item->is_active
            ];
        }

        $title_id = $signage_specification->first()->title->name;
        $data = [
            'status' => true,
            'message' => 'Here are our signage specification list:',
            'title' => $title_id,
            'data' => $formatteditem
        ];

        return response()->json($data, 200);
    }

    public function infoOfSignageSpecification()
    {
        $signage_specification = SignageSpecification::select(['title_id', 'feature', 'inch_86_ifp', 'inch_75_ifp', 'inch_65_ifp', 'is_active'])
            ->get();

        $formatteditem = [];

        foreach ($signage_specification as $item) {
            $formatteditem[] = [
                'feature' => $item->feature,
                'inch_86_ifp' => $item->inch_86_ifp,
                'inch_75_ifp' => $item->inch_75_ifp,
                'inch_65_ifp' => $item->inch_65_ifp,
                'is_active' => $item->is_active
            ];
        }

        $title_id = $signage_specification->first()->title->name;
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
            'is_active' => $request->is_active
        ]);

        $all_data = [
            'link_name' => $video->link_name,
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
        $data = SignageVideoLink::where('is_active', true)->first();

        $data = [
            'status' => true,
            'message' => 'Here video details',
            'data' => $data,

        ];
        return response()->json($data, 200);
    }

    public function videoLinkInfo()
    {
        $data = SignageVideoLink::first();

        $data = [
            'status' => true,
            'message' => 'Here video details',
            'data' => $data,

        ];
        return response()->json($data, 200);
    }
}
