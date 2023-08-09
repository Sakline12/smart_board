<?php

namespace App\Http\Controllers;

use App\Models\Csp;
use App\Models\Edu;
use App\Models\IndexSlider;
use App\Models\Panel;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{

    //Slider
    public function create_index_slider(Request $request)
    {
        $rules = array(
            'image' => 'required',
            'title' => 'required',
            'content' =>  'required',
            'button_text' => 'required',
            'button_link' => 'required',
        );


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 403);
        }

        $index = new IndexSlider();
        if ($image = $request->file('image')) {
            $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('index'), $imageName);
        }

        $index->title = $request->title;
        $index->content = $request->content;
        $index->button_text = $request->button_text;
        $index->button_link = $request->button_link;
        $index->image = $imageName;

        if ($index->save()) {
            $data = [
                'status' => true,
                'message' => 'Index slider successfully created',
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

    public function show_slider_index()
    {
        $index = IndexSlider::where('isActive', true)->get();
        $data = [
            'status' => true,
            'message' => 'Here are your index items',
            'data' => $index
        ];
        return response()->json($data, 200);
    }

    public function delete_index_slider(Request $request, $id)
    {
        $index = IndexSlider::where('id', $id)->delete();
        if ($index) {
            $data = [
                'status' => true,
                'message' => 'Delete this items successfully',
                'data' => $index
            ];
            return response()->json($data);
        } else {
            $data = [
                'status' => false,
                'message' => 'Error has has been occured',
                'data' => $index
            ];
            return response()->json($data, 500);
        }
    }

    public function update_index_slider(Request $request, $id)
    {
        $index = IndexSlider::find($id);
        if (!$index) {
            return response()->json([
                'status' => false,
                'message' => 'Slider items not found',
            ], 404);
        }

        if ($image = $request->file('image')) {
            if ($index->image && file_exists(public_path('profile') . '/' . $index->image)) {
                unlink(public_path('profile') . '/' . $index->image);
            }

            $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('profile'), $imageName);

            $index->update([
                'image' => $imageName,
            ]);
        }

        $index->update([
            'title' => $request->title,
            'content' => $request->content,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'isActive' => $request->isActive,
        ]);

        $all_data = [
            'image' => $index->image,
            'title' => $index->title,
            'content' => $index->content,
            'button_text' => $index->button_text,
            'isActive' => $index->isActive,
        ];

        $data = [
            'status' => 200,
            'message' => "User updated successfully",
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function slider_item_list()
    {
        $index = IndexSlider::all();

        $data = [
            'status' => true,
            'message' => "Here are all index slider:",
            'data' => $index
        ];
        return response()->json($data);
    }

    //Product
    public function create_product(Request $request)
    {
        $rules = array(
            'title_id' => 'required',
            'product_image' =>  'required',
            'background_img' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 403);
        }

        $existingProduct = Product::where('title_id', $request->title_id)->first();
        if ($existingProduct) {
            return response()->json([
                'status' => false,
                'message' => 'Product with the same title_id already exists',
                'data' => [],
            ], 409);
        }

        $index = new Product();
        if ($productimage = $request->file('product_image')) {
            $imageName1 = time() . '-' . uniqid() . '.' . $productimage->getClientOriginalExtension();
            $productimage->move(public_path('index'), $imageName1);
        }

        if ($backgroundimage = $request->file('background_img')) {
            $imageName2 = time() . '-' . uniqid() . '.' . $backgroundimage->getClientOriginalExtension();
            $backgroundimage->move(public_path('index'), $imageName2);
        }

        $index->title_id = $request->title_id;
        $index->product_image = $imageName1;
        $index->background_img = $imageName2;
        $index->save();

        if ($index->save()) {
            $data = [
                'status' => true,
                'message' => 'Product successfully created',
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


    public function show_product()
    {
        $index = Product::where('isActive', true)->get();
        $data = [
            'status' => true,
            'message' => 'Here are your product items',
            'data' => $index
        ];
        return response()->json($data, 200);
    }

    public function delete_product(Request $request, $id)
    {
        $index = Product::where('id', $id)->delete();
        if ($index) {
            $data = [
                'status' => true,
                'message' => 'Delete this product successfully',
                'data' => $index
            ];
            return response()->json($data);
        } else {
            $data = [
                'status' => false,
                'message' => 'Error has has been occured',
                'data' => $index
            ];
            return response()->json($data, 500);
        }
    }

    public function update_product(Request $request, $id)
    {
        $index = Product::find($id);
        if (!$index) {
            return response()->json([
                'status' => false,
                'message' => 'Product items not found',
            ], 404);
        }

        if ($image1 = $request->file('product_image')) {
            if ($index->product_image && file_exists(public_path('index') . '/' . $index->product_image)) {
                unlink(public_path('index') . '/' . $index->product_image);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('index'), $imageName1);

            $index->update([
                'product_image' => $imageName1,
            ]);
        }

        if ($image2 = $request->file('background_img')) {
            if ($index->background_img && file_exists(public_path('index') . '/' . $index->background_img)) {
                unlink(public_path('index') . '/' . $index->background_img);
            }

            $imageName2 = time() . '-' . uniqid() . '.' . $image2->getClientOriginalExtension();
            $image2->move(public_path('index'), $imageName2);

            $index->update([
                'background_img' => $imageName2,
            ]);
        }

        $index->update([
            'title_id' => $request->title_id
        ]);

        $all_data = [
            'title_id' => $index->title_id,
        ];

        $data = [
            'status' => 200,
            'message' => "Product updated successfully",
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function product_item_list()
    {
        $index = Product::all();

        $data = [
            'status' => true,
            'message' => "Here are product:",
            'data' => $index
        ];
        return response()->json($data);
    }

    //pannel
    public function create_panel(Request $request)
    {
        $rules = array(
            'title_id' => 'required',
            'description' => 'required',
            'image' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 403);
        }

        if ($request->input('title_id') != 2) {
            return response()->json([
                'status' => false,
                'message' => 'Panel can only be created with title_id equal to 2',
                'data' => [],
            ], 400);
        }

        $existingPanel = Panel::where('title_id', $request->input('title_id'))->first();
        if ($existingPanel) {
            return response()->json([
                'status' => false,
                'message' => 'Panel with the same title_id already exists',
                'data' => [],
            ], 409);
        }

        $index = new Panel();
        if ($panelimage = $request->file('image')) {
            $imageName1 = time() . '-' . uniqid() . '.' . $panelimage->getClientOriginalExtension();
            $panelimage->move(public_path('index'), $imageName1);
        }

        $index->title_id = $request->input('title_id');
        $index->description = $request->input('description');
        $index->image = $imageName1;

        $index->save();

        if ($index->save()) {
            $data = [
                'status' => true,
                'message' => 'Panel successfully created',
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

    public function showPanel()
    {
        $index = Panel::where('isActive', true)->get();
        $data = [
            'status' => true,
            'message' => 'Here are your index items',
            'data' => $index
        ];
        return response()->json($data, 200);
    }

    public function updatePanel(Request $request, $id)
    {
        $index = Panel::find($id);
        if (!$index) {
            return response()->json([
                'status' => false,
                'message' => 'Panel items not found',
            ], 404);
        }

        if ($image = $request->file('image')) {
            if ($index->image && file_exists(public_path('panel') . '/' . $index->image)) {
                unlink(public_path('panel') . '/' . $index->image);
            }

            $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('panel'), $imageName);

            $index->update([
                'image' => $imageName,
            ]);
        }

        $index->update([
            'title_id' => $request->title_id,
            'description' => $request->description,
            'isActive' => $request->isActive
        ]);

        $data = [
            'title_id' => $index->title_id,
            'description' => $index->description,
            'isActive' => $index->isActive,
        ];

        $data = [
            'status' => 200,
            'message' => "Panel updated successfully",
            'data' => $data,
        ];

        return response()->json($data);
    }

    //csp
    public function createSolutionProvider(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_id' => 'required|integer',
            'image' => 'required|image',
            'subtitle' => 'required',
            'description' => 'required',
            'button_text' => 'required',
            'button_link' => 'required|url'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 400);
        }

        if ($request->input('title_id') != 3) {
            return response()->json([
                'status' => false,
                'message' => 'Panel can only be created with title_id equal to 3',
                'data' => [],
            ], 400);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('csp'), $imageName);
        }

        $csp = new CSP();
        $csp->title_id = $request->title_id;
        $csp->image = $imageName;
        $csp->subtitle = $request->subtitle;
        $csp->description = $request->description;
        $csp->button_text = $request->button_text;
        $csp->button_link = $request->button_link;
        $csp->save();

        if ($csp) {
            $data = [
                'status' => true,
                'message' => 'CSP successfully created',
                'data' => $csp,
            ];
            return response()->json($data, 201);
        } else {
            $data = [
                'status' => false,
                'message' => 'Error occurred',
                'data' => [
                    'title_name' => $csp->title->title_id,
                ],
            ];
            return response()->json($data, 500);
        }
    }

    public function showCsp()
    {
        $csps = Csp::where('isActive', true)
            ->select(['title_id', 'image', 'subtitle', 'description', 'button_text', 'button_link'])
            ->get();

        $formattedCsps = [];

        foreach ($csps as $csp) {
            $formattedCsps[] = [
                'image' => $csp->image,
                'subtitle' => $csp->subtitle,
                'description' => $csp->description,
                'button_text' => $csp->button_text,
                'button_link' => $csp->button_link,
            ];
        }

        $firstCspTitle = $csps->first()->title->name;

        $data = [
            'status' => true,
            'message' => 'Here are your csp items',
            'title' => $firstCspTitle,
            'data' => $formattedCsps
        ];

        return response()->json($data, 200);
    }

    public function updateCsp(Request $request, $id)
    {
        $index = CSP::find($id);
        if (!$index) {
            return response()->json([
                'status' => false,
                'message' => 'CSP items not found',
            ], 404);
        }

        if ($image1 = $request->file('image')) {
            if ($index->image && file_exists(public_path('csp') . '/' . $index->image)) {
                unlink(public_path('csp') . '/' . $index->image);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('csp'), $imageName1);

            $index->update([
                'image' => $imageName1,
            ]);
        }
        $index->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'button_link' => $request->button_link,
            'button_text' => $request->button_text,
            'isActive' => $request->isActive
        ]);

        $all_data = [
            'subtitle' => $index->subtitle,
            'image' => $index->image,
            'description' => $index->description,
            'button_link' => $index->button_link,
            'button_text' => $index->button_text,
            'isActive' => $index->isActive
        ];

        $data = [
            'status' => 200,
            'message' => "Product updated successfully",
            'title' => $index->title->name,
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function deleteCsp(Request $request, $id)
    {
        $index = Csp::where('id', $id)->delete();
        if ($index) {
            $data = [
                'status' => true,
                'message' => 'Delete this Csp successfully',
                'data' => $index
            ];
            return response()->json($data);
        } else {
            $data = [
                'status' => false,
                'message' => 'Error has has been occured',
                'data' => $index
            ];
            return response()->json($data, 500);
        }
    }

    public function createEdu(Request $request)
    {
        $rules = array(
            'header_title' => 'required',
            'heading_description' => 'required',
            'image' => 'required',
            'title' => 'required',
            'description' => 'required',
            'button_text' => 'required',
            'button_link' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 403);
        }

        if ($request->input('header_title') != 4) {
            return response()->json([
                'status' => false,
                'message' => 'Panel can only be created with header_title equal to 4',
                'data' => [],
            ], 400);
        }

        $existingPanel = Edu::where('header_title', $request->input('header_title'))->first();
        if ($existingPanel) {
            return response()->json([
                'status' => false,
                'message' => 'Panel with the same title_id already exists',
                'data' => [],
            ], 409);
        }

        $index = new Edu();
        if ($panelimage = $request->file('image')) {
            $imageName1 = time() . '-' . uniqid() . '.' . $panelimage->getClientOriginalExtension();
            $panelimage->move(public_path('edu'), $imageName1);
        }

        $index->header_title = $request->input('header_title');
        $index->heading_description = $request->input('heading_description');
        $index->image = $imageName1;
        $index->title = $request->input('title');
        $index->description = $request->input('description');
        $index->button_text = $request->input('button_text');
        $index->button_link = $request->input('button_link');
        $index->save();

        if ($index->save()) {
            $data = [
                'status' => true,
                'message' => 'Edu successfully created',
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

    public function updateEdu(Request $request, $id)
    {
        $index = Edu::find($id);
        if (!$index) {
            return response()->json([
                'status' => false,
                'message' => 'Edu items not found',
            ], 404);
        }

        if ($image1 = $request->file('image')) {
            if ($index->image && file_exists(public_path('edu') . '/' . $index->image)) {
                unlink(public_path('edu') . '/' . $index->image);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('edu'), $imageName1);

            $index->update([
                'image' => $imageName1,
            ]);
        }
        $index->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'button_link' => $request->button_link,
            'button_text' => $request->button_text,
            'isActive' => $request->isActive
        ]);

        $all_data = [
            'subtitle' => $index->subtitle,
            'image' => $index->image,
            'description' => $index->description,
            'button_link' => $index->button_link,
            'button_text' => $index->button_text,
            'isActive' => $index->isActive
        ];

        $data = [
            'status' => 200,
            'message' => "Product updated successfully",
            'title' => $index->title->name,
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    
}
