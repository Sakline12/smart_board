<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AboutController extends Controller
{
    public function createAbout(Request $request)
    {
        $rules = array(
            'header_title' => 'required',
            'background_image' => 'required',
            'question' => 'required',
            'description' => 'required',
            'image' => 'required',
            'button_text' => 'required',
            'button_link'=>'required'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 403);
        }

        if ($request->input('header_title') != 11) {
            return response()->json([
                'status' => false,
                'message' => 'Feature can only be created with title equal to 11',
                'data' => [],
            ], 400);
        }

        $existingsequence = About::where('header_title', $request->input('header_title'))->first();
        if ($existingsequence) {
            return response()->json([
                'status' => false,
                'message' => 'About already existed',
                'data' => [],
            ], 409);
        }

        $index = new About();
        if ($panelimage = $request->file('background_image')) {
            $imageName1 = time() . '-' . uniqid() . '.' . $panelimage->getClientOriginalExtension();
            $panelimage->move(public_path('About'), $imageName1);
        }

        if ($panelimage1 = $request->file('image')) {
            $imageName2 = time() . '-' . uniqid() . '.' . $panelimage1->getClientOriginalExtension();
            $panelimage1->move(public_path('About'), $imageName2);
        }

        $index->header_title = $request->header_title;
        $index->background_image = $imageName1;
        $index->question = $request->question;
        $index->description = $request->description;
        $index->image=$imageName2;
        $index->button_text = $request->button_text;
        $index->button_link = $request->button_link;
        $index->save();

        if ($index->save()) {
            $data = [
                'status' => true,
                'message' => 'About successfully created',
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

    public function updateAbout(Request $request, $id)
    {
        $index = About::find($id);
        if (!$index) {
            return response()->json([
                'status' => false,
                'message' => 'About not found',
            ], 404);
        }

        if ($image1 = $request->file('background_image')) {
            if ($index->background_image && file_exists(public_path('About') . '/' . $index->background_image)) {
                unlink(public_path('About') . '/' . $index->background_image);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('About'), $imageName1);

            $index->update([
                'background_image' => $imageName1,
            ]);
        }

        if ($image2 = $request->file('image')) {
            if ($index->image && file_exists(public_path('About') . '/' . $index->image)) {
                unlink(public_path('About') . '/' . $index->image);
            }

            $imageName2 = time() . '-' . uniqid() . '.' . $image2->getClientOriginalExtension();
            $image2->move(public_path('About'), $imageName2);

            $index->update([
                'image' => $imageName2,
            ]);
        }

        $index->update([
            'header_title' => $request->header_title,
            'question' => $request->question,
            'description' => $request->description,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'isActive' => $request->isActive
        ]);

        $all_data = [
            'question' => $index->question,
            'description'=>$index->description,
            'button_text' => $index->button_text,
            'button_link'=>$index->button_link,
            'isActive' => $index->isActive
        ];

        $data = [
            'status' => 200,
            'message' => "About updated successfully",
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function aboutDetails(){
        $pro = About::where('isActive', true)->first();

        $data = [
            'status' => true,
            'message' => 'Here about details',
            'title' => $pro->title->name,
            'data' => $pro,

        ];
        return response()->json($data, 200);
    }
}
