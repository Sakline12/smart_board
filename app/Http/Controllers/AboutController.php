<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AboutController extends Controller
{
    public function createAbout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'header_title' => 'required',
            'background_image' => 'required',
            'question' => 'required',
            'description' => 'required',
            'image' => 'required',
            'button_text' => 'required',
            'button_link' => 'required'
        ]);

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

        $about = new About();
        if ($panelimage = $request->file('background_image')) {
            $imageName1 = time() . '-' . uniqid() . '.' . $panelimage->getClientOriginalExtension();
            $panelimage->move(public_path('about'), $imageName1);
        }

        if ($panelimage1 = $request->file('image')) {
            $imageName2 = time() . '-' . uniqid() . '.' . $panelimage1->getClientOriginalExtension();
            $panelimage1->move(public_path('about'), $imageName2);
        }

        $about->header_title = $request->header_title;
        $about->background_image = $imageName1;
        $about->question = $request->question;
        $about->description = $request->description;
        $about->image = $imageName2;
        $about->button_text = $request->button_text;
        $about->button_link = $request->button_link;
        $about->save();

        if ($about->save()) {
            $data = [
                'status' => true,
                'message' => 'About successfully created',
                'data' => $about,
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

    public function updateAbout(Request $request)
    {
        $id=$request->id;
        $about = About::find($id);
        if (!$about) {
            return response()->json([
                'status' => false,
                'message' => 'About not found',
            ], 404);
        }

        if ($image1 = $request->file('background_image')) {
            if ($about->background_image && file_exists(public_path('about') . '/' . $about->background_image)) {
                unlink(public_path('about') . '/' . $about->background_image);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('about'), $imageName1);

            $about->update([
                'background_image' => $imageName1,
            ]);
        }

        if ($image2 = $request->file('image')) {
            if ($about->image && file_exists(public_path('about') . '/' . $about->image)) {
                unlink(public_path('about') . '/' . $about->image);
            }

            $imageName2 = time() . '-' . uniqid() . '.' . $image2->getClientOriginalExtension();
            $image2->move(public_path('about'), $imageName2);

            $about->update([
                'image' => $imageName2,
            ]);
        }

        $about->update([
            'header_title' => $request->header_title,
            'question' => $request->question,
            'description' => $request->description,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'is_active' => $request->is_active
        ]);

        $all_data = [
            'question' => $about->question,
            'description' => $about->description,
            'button_text' => $about->button_text,
            'button_link' => $about->button_link,
            'is_active' => $about->is_active
        ];

        $data = [
            'status' => 200,
            'message' => "About updated successfully",
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function aboutDetails()
    {
        $about = About::where('is_active', true)->first();

        if ($about) {
            $data = [
                'status' => true,
                'message' => 'Here about details',
                'title' => $about->title->name,
                'data' => $about,

            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => false,
                'message' => 'Data is none.',
                'data' => $about,

            ];
            return response()->json($data, 404);
        }
    }

    public function aboutInformation()
    {
        $about = About::first();

        if ($about) {
            $data = [
                'status' => true,
                'message' => 'Here about details',
                'title' => $about->title->name,
                'data' => $about,

            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => false,
                'message' => 'Data is not active.',
                'data' => $about,

            ];
            return response()->json($data, 404);
        }
    }
}
