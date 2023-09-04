<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use App\Models\DeviceImage;
use App\Models\PodiumPrsesntationImage;
use App\Models\SubTitle;
use App\Models\Title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    //title
    public function createTitle(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 403);
        }

        $existingsequence = Title::where('name', $request->input('name'))->first();
        if ($existingsequence) {
            return response()->json([
                'status' => false,
                'message' => 'Title already existed',
                'data' => [],
            ], 409);
        }

        $title = new Title();
        $title->name = $request->name;
        $title->category = $request->category;
        $title->save();

        if ($title->save()) {
            $data = [
                'status' => true,
                'message' => 'title successfully created',
                'data' => $title,
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

    public function updateTitle(Request $request, $id)
    {
        $title = Title::find($id);
        if (!$title) {
            return response()->json([
                'status' => false,
                'message' => 'Titles not found',
            ], 404);
        }

        $title->update([
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'is_active' => $request->is_active
        ]);

        $all_data = [
            'name' => $title->name,
            'category' => $title->category,
            'description' => $title->description,
            'is_active' => $title->is_active,

        ];

        $data = [
            'status' => 200,
            'message' => "Title introduction updated successfully",
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function titleList()
    {
        $title = Title::all();
        $data = [
            'status' => true,
            'message' => "Here are all title items:",
            'data' => $title
        ];
        return response()->json($data);
    }

    //Department
    public function createDepartment(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 403);
        }

        $existingsequence = Department::where('name', $request->input('name'))->first();
        if ($existingsequence) {
            return response()->json([
                'status' => false,
                'message' => 'Department already existed',
                'data' => [],
            ], 409);
        }

        $department = new Department();
        $department->name = $request->name;
        $department->save();

        if ($department->save()) {
            $data = [
                'status' => true,
                'message' => 'Department successfully created',
                'data' => $department,
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

    public function updatedepartment(Request $request, $id)
    {
        $department = Department::find($id);
        if (!$department) {
            return response()->json([
                'status' => false,
                'message' => 'Departments not found',
            ], 404);
        }

        $department->update([
            'name' => $request->name,
            'is_active' => $request->is_active
        ]);

        $all_data = [
            'name' => $department->name,
            'is_active' => $department->is_active,

        ];

        $data = [
            'status' => 200,
            'message' => "Department updated successfully",
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function departmentDelete(Request $request, $id)
    {
        $department = Department::where('id', $id)->delete();
        if ($department) {
            $data = [
                'status' => true,
                'message' => 'Delete this items successfully',
                'data' => $department
            ];
            return response()->json($data);
        } else {
            $data = [
                'status' => false,
                'message' => 'Error has has been occured',
                'data' => $department
            ];
            return response()->json($data, 500);
        }
    }

    public function DepartmentList()
    {
        $department = Department::all();
        $data = [
            'status' => true,
            'message' => "Here are all department items:",
            'data' => $department
        ];
        return response()->json($data);
    }

    //Designation
    public function createDesignation(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 403);
        }

        $existingsequence = Designation::where('title', $request->input('title'))->first();
        if ($existingsequence) {
            return response()->json([
                'status' => false,
                'message' => 'Designation already existed',
                'data' => [],
            ], 409);
        }

        $designation = new Designation();
        $designation->name = $request->name;
        $designation->save();

        if ($designation->save()) {
            $data = [
                'status' => true,
                'message' => 'Designation successfully created',
                'data' => $designation,
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

    public function updateDesignation(Request $request, $id)
    {
        $designation = Designation::find($id);
        if (!$designation) {
            return response()->json([
                'status' => false,
                'message' => 'Designations not found',
            ], 404);
        }

        $designation->update([
            'title' => $request->title,
            'is_active' => $request->is_active
        ]);

        $all_data = [
            'title' => $designation->title,
            'is_active' => $designation->is_active,

        ];

        $data = [
            'status' => 200,
            'message' => "Designation updated successfully",
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function designationDelete(Request $request, $id)
    {
        $designation = Designation::where('id', $id)->delete();
        if ($designation) {
            $data = [
                'status' => true,
                'message' => 'Delete this items successfully',
                'data' => $designation
            ];
            return response()->json($data);
        } else {
            $data = [
                'status' => false,
                'message' => 'Error has has been occured',
                'data' => $designation
            ];
            return response()->json($data, 500);
        }
    }

    public function designationList()
    {
        $designation = Designation::all();
        $data = [
            'status' => true,
            'message' => "Here are all designation items:",
            'data' => $designation
        ];
        return response()->json($data);
    }

    //sub title
    public function createSubTitle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 403);
        }

        $existingsequence = SubTitle::where('name', $request->input('name'))->first();
        if ($existingsequence) {
            return response()->json([
                'status' => false,
                'message' => 'Sub title already existed',
                'data' => [],
            ], 409);
        }

        $subtitle = new SubTitle();
        $subtitle->name = $request->name;
        $subtitle->description = $request->description;
        $subtitle->category = $request->category;
        $subtitle->save();

        if ($subtitle->save()) {
            $data = [
                'status' => true,
                'message' => 'Sub title successfully created',
                'data' => $subtitle,
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

    public function subTitleList()
    {
        $subtitle = SubTitle::all();

        $data = [
            'status' => true,
            'message' => 'Here are sub title list:',
            'data' => $subtitle
        ];

        return response()->json($data, 200);
    }

    public function deleteSubtitle(Request $request, $id)
    {
        $subtitle = SubTitle::where('id', $id)->delete();
        if ($subtitle) {
            $data = [
                'status' => true,
                'message' => 'Delete this items successfully',
                'data' => $subtitle
            ];
            return response()->json($data);
        } else {
            $data = [
                'status' => false,
                'message' => 'Error has has been occured',
                'data' => $subtitle
            ];
            return response()->json($data, 500);
        }
    }

    public function updateSubTitle(Request $request, $id)
    {
        $subtitle = SubTitle::find($id);
        if (!$subtitle) {
            return response()->json([
                'status' => false,
                'message' => 'Sub titles not found',
            ], 404);
        }

        $subtitle->update([
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'is_active' => $request->is_active
        ]);

        $all_data = [
            'name' => $subtitle->name,
            'category' => $subtitle->category,
            'description' => $subtitle->description,
            'is_active' => $subtitle->is_active,

        ];

        $data = [
            'status' => 200,
            'message' => "Sub title introduction updated successfully",
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    //Device image
    // public function createDeviceImage(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'image' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Validation Failed',
    //             'errors' => $validator->errors()
    //         ], 403);
    //     }

    //     $device_image = DeviceImage::where('image', $request->input('image'))->first();
    //     if ($device_image) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Same image already exists',
    //             'data' => [],
    //         ], 409);
    //     }


    //     $device_image = new DeviceImage();
    //     if ($panelimage = $request->file('image_one')) {
    //         $imageName1 = time() . '-' . uniqid() . '.' . $panelimage->getClientOriginalExtension();
    //         $panelimage->move(public_path('Wireless device'), $imageName1);
    //     }

    //     $device_image->title_id = $request->title_id;
    //     $device_image->image_one = $imageName1;
    //     $device_image->save();

    //     if ($device_image->save()) {
    //         $data = [
    //             'status' => true,
    //             'message' => 'Device image successfully created',
    //             'data' => $device_image,
    //         ];
    //         return response()->json($data, 201);
    //     } else {
    //         $data = [
    //             'status' => false,
    //             'message' => 'Error occurred',
    //             'data' => [],
    //         ];
    //         return response()->json($data, 501);
    //     }
    // }
    //Device image
    public function createDeviceImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 400);
        }

        $imageCount = DeviceImage::count();
        if ($imageCount >= 3) {
            return response()->json([
                'status' => false,
                'message' => 'Maximum image limit (3) reached',
                'data' => [],
            ], 403);
        }

        if ($image = $request->file('image')) {
            $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('deviceimage'), $imageName);

            $device_image = new DeviceImage();
            $device_image->image = $imageName;
            $device_image->save();

            if ($device_image) {
                $data = [
                    'status' => true,
                    'message' => 'Device image successfully created',
                    'data' => $device_image,
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
        } else {
            return response()->json([
                'status' => false,
                'message' => 'No image file provided',
                'data' => [],
            ], 400);
        }
    }

    public function updateDeviceImage(Request $request, $id)
    {
        $deviceImage = DeviceImage::find($id);

        if (!$deviceImage) {
            return response()->json([
                'status' => false,
                'message' => 'Device image not found',
                'data' => [],
            ], 404);
        }

        if ($image = $request->file('image')) {
            $imagePath = public_path('deviceimage') . '/';

            if ($deviceImage->image && file_exists($imagePath . $deviceImage->image)) {
                unlink($imagePath . $deviceImage->image);
            }

            $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($imagePath, $imageName);

            $deviceImage->image = $imageName;
            $deviceImage->save();

            return response()->json([
                'status' => true,
                'message' => 'Device image updated successfully',
                'data' => [
                    'image' => $imageName,
                ],
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'No image file provided',
                'data' => [],
            ], 400);
        }
    }

    public function listOfDeviceImage()
    {
        $device_image = DeviceImage::all();

        $data = [
            'status' => true,
            'message' => 'Here are list of images:',
            'data' => $device_image

        ];

        return response()->json($data);
    }

    public function createPodiumPresentationImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 400);
        }

        $imageCount = PodiumPrsesntationImage::count();
        if ($imageCount >= 3) {
            return response()->json([
                'status' => false,
                'message' => 'Maximum image limit (3) reached',
                'data' => [],
            ], 403);
        }

        if ($image = $request->file('image')) {
            $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('presentationimage'), $imageName);

            $device_image = new PodiumPrsesntationImage();
            $device_image->image = $imageName;
            $device_image->save();

            if ($device_image) {
                $data = [
                    'status' => true,
                    'message' => 'Podium presentation image successfully created',
                    'data' => $device_image,
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
        } else {
            return response()->json([
                'status' => false,
                'message' => 'No image file provided',
                'data' => [],
            ], 400);
        }
    }

}
