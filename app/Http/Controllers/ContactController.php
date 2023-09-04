<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\ContactIntroduction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use PHPMailer\PHPMailer\PHPMailer;
use App\Models\Location;

class ContactController extends Controller
{
    //Contact introduction
    public function createContactIntroduction(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title_id' => 'required',
            'background_image' => 'required',
        ]);

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
            $panelimage->move(public_path('contact'), $imageName1);
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
            if ($Contact->background_image && file_exists(public_path('contact') . '/' . $Contact->background_image)) {
                unlink(public_path('contact') . '/' . $Contact->background_image);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('contact'), $imageName1);

            $Contact->update([
                'background_image' => $imageName1,
            ]);
        }

        $Contact->update([
            'title_id' => $request->title_id,
            'is_active' => $request->is_active
        ]);

        $all_data = [
            'title_id' => $Contact->title_id,
            'is_active' => $Contact->is_active
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
        $data = ContactIntroduction::where('is_active', true)->first();
        $title = $data->title->name;
        $data = [
            'status' => true,
            'message' => 'Here contact introduction details',
            'title' => $title,
            'data' => $data,
        ];
        return response()->json($data, 200);
    }

    public function contactIntroductionInfo()
    {
        $data = ContactIntroduction::first();
        $title = $data->title->name;
        $data = [
            'status' => true,
            'message' => 'Here contact introduction details',
            'title' => $title,
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
            'mail' => 'required'
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
            'mail' => $request->mail,
            'is_active' => $request->is_active
        ]);

        $all_data = [
            'address' => $location->address,
            'phone' => $location->phone,
            'mail' => $location->mail,
            'is_active' => $location->is_active
        ];

        $data = [
            'status' => 200,
            'message' => "location updated successfully",
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function locationDetails()
    {
        $data = Location::all();
        $data = [
            'status' => true,
            'message' => 'Here location details',
            'data' => $data,
        ];
        return response()->json($data, 200);
    }

    public function sendEmail(Request $request)
    {
        $email = $request->input('mail');
        $subject = $request->input('subject');
        $message = htmlspecialchars($request->input('message'), ENT_QUOTES, 'UTF-8');

        $mail = new Contact();
        $mail->mail = $email;
        $mail->subject = $subject;
        $mail->message = $message;
        $mail->save();

        $submit_message = "
        <table style='width: 100%; border-collapse: collapse;'>
        <tr style='background-color: #115060; color: white;'>
        <th style='padding: 10px; border: 1px solid #ddd;'>Field</th>
        <th style='padding: 10px; border: 1px solid #ddd;'>Value</th>
        </tr>
        <tr>
        <td style='padding: 10px; border: 1px solid #ddd;'>From</td>
        <td style='padding: 10px; border: 1px solid #ddd;'>$email</td>
        </tr>
        <tr>
        <td style='padding: 10px; border: 1px solid #ddd;'>Subject</td>
        <td style='padding: 10px; border: 1px solid #ddd;'>$subject</td>
        </tr>
        <tr>
        <td style='padding: 10px; border: 1px solid #ddd;'>Details</td>
        <td style='padding: 10px; border: 1px solid #ddd;'>$message</td>
        </tr>
        </table>
        ";


        $mail = new PHPMailer(true);

        try {
            // SMTP Settings
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = "bacbonapplication@gmail.com";
            $mail->Password = 'lzhumcnodpywvyxu';
            $mail->Port = 587;
            $mail->SMTPSecure = "tls";

            // Email Settings
            $mail->isHTML(true);
            $mail->setFrom($email);
            $mail->addAddress("bacbonapplication@gmail.com");
            $mail->Subject = "$email ($subject)";
            $mail->Body = $submit_message;

            $mail->send();

            $status = "success";
            $response = "Email is sent!";
        } catch (\Exception $e) {
            $status = "failed";
            $response = "Something is wrong: " . $e->getMessage();
        }

        return response()->json(["status" => $status, "response" => $response]);
    }

    public function deleteMail(Request $request, $id)
    {
        $Mail = Contact::where('id', $id)->delete();
        if ($Mail) {
            $data = [
                'status' => true,
                'message' => 'Delete this items successfully',
                'data' => $Mail
            ];
            return response()->json($data);
        } else {
            $data = [
                'status' => false,
                'message' => 'Error has has been occured',
                'data' => $Mail
            ];
            return response()->json($data, 500);
        }
    }

    public function mailList()
    {
        $data = Contact::all();
        $data = [
            'status' => true,
            'message' => 'Here contact details',
            'data' => $data,
        ];
        return response()->json($data, 200);
    }
}
