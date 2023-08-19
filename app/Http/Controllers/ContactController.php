<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\ContactIntroduction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use App\Models\Location;

class ContactController extends Controller
{
    //Contact introduction
    public function createContactIntroduction(Request $request)
    {
        $rules = array(
            'title_id' => 'required',
            'background_image' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 403);
        }

        if ($request->input('title_id') != 25) {
            return response()->json([
                'status' => false,
                'message' => 'Contact can only be created with title equal to 25',
                'data' => [],
            ], 400);
        }

        $existingsequence = ContactIntroduction::where('title_id', $request->input('title_id'))->first();
        if ($existingsequence) {
            return response()->json([
                'status' => false,
                'message' => 'Contact already existed',
                'data' => [],
            ], 409);
        }

        $contact = new ContactIntroduction();
        if ($panelimage = $request->file('background_image')) {
            $imageName1 = time() . '-' . uniqid() . '.' . $panelimage->getClientOriginalExtension();
            $panelimage->move(public_path('Contact'), $imageName1);
        }

        $contact->title_id = $request->title_id;
        $contact->background_image = $imageName1;
        $contact->save();

        if ($contact->save()) {
            $data = [
                'status' => true,
                'message' => 'Contact successfully created',
                'data' => $contact,
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

    public function updateContactIntroduction(Request $request, $id)
    {
        $Contact = ContactIntroduction::find($id);
        if (!$Contact) {
            return response()->json([
                'status' => false,
                'message' => 'Contact introduction not found',
            ], 404);
        }

        if ($image1 = $request->file('background_image')) {
            if ($Contact->background_image && file_exists(public_path('Contact') . '/' . $Contact->background_image)) {
                unlink(public_path('Contact') . '/' . $Contact->background_image);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('Contact'), $imageName1);

            $Contact->update([
                'background_image' => $imageName1,
            ]);
        }

        $Contact->update([
            'title_id' => $request->title_id,
            'isActive' => $request->isActive
        ]);

        $all_data = [
            'title_id' => $Contact->title_id,
            'isActive' => $Contact->isActive
        ];

        $data = [
            'status' => 200,
            'message' => "Contact introduction updated successfully",
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function contactIntroductionDetails()
    {
        $data = ContactIntroduction::where('isActive', true)->first();
        $title=$data->title->name;
        $data = [
            'status' => true,
            'message' => 'Here contact introduction details',
            'title'=>$title,
            'data' => $data,
        ];
        return response()->json($data, 200);
    }

    //Mail
    public function mailSend(Request $request)
    {
       return response()->json('Thanks');
    }


    //Location
    public function createLocation(Request $request)
    {
        $rules = array(
            'address' => 'required',
            'phone' => 'required',
            'mail'=>'required'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 403);
        }

        $existingsequence = Location::where('address', $request->input('address'))->first();
        if ($existingsequence) {
            return response()->json([
                'status' => false,
                'message' => 'Location already existed',
                'data' => [],
            ], 409);
        }

        $location = new Location();
        $location->address = $request->address;
        $location->phone = $request->phone;
        $location->mail = $request->mail;
        $location->save();

        if ($location->save()) {
            $data = [
                'status' => true,
                'message' => 'location successfully created',
                'data' => $location,
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

    public function updateLocation(Request $request, $id)
    {
        $location = Location::find($id);
        if (!$location) {
            return response()->json([
                'status' => false,
                'message' => 'location not found',
            ], 404);
        }

        $location->update([
            'address' => $request->address,
            'phone' => $request->phone,
            'mail'=>$request->mail,
            'isActive'=>$request->isActive
        ]);

        $all_data = [
            'address' => $location->address,
            'phone' => $location->phone,
            'mail' => $location->mail,
            'isActive' => $location->isActive
        ];

        $data = [
            'status' => 200,
            'message' => "location updated successfully",
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function locationDetails(){
        $data = Location::all();
        $data = [
            'status' => true,
            'message' => 'Here location details',
            'data' => $data,
        ];
        return response()->json($data, 200);
    }

    public function mailSent(Request $request){
        $data = $request->validate([
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        $contact = Contact::create($data);

        // Mail::to($contact->email)->send(new SendEmail($contact));

        return response()->json(['message' => 'Email sent successfully'], 200);
    }
}
