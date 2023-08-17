<?php

namespace App\Http\Controllers;

use App\Models\CaseStudy;
use App\Models\Conference;
use App\Models\Csp;
use App\Models\Education;
use App\Models\FeatureProduct;
use App\Models\HonorableClient;
use App\Models\IndexSlider;
use App\Models\OurTeam;
use App\Models\Panel;
use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{

    //Slider
    public function createIndexSlider(Request $request)
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

    public function listOfIndexSlider()
    {
        $index = IndexSlider::where('isActive', true)->get();
        $data = [
            'status' => true,
            'message' => 'Here are your index items',
            'data' => $index
        ];
        return response()->json($data, 200);
    }

    public function deleteIndexSlider(Request $request, $id)
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

    public function updateIndexSlider(Request $request, $id)
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

    public function sliderItemList()
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
    public function createProduct(Request $request)
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


    public function allProduct()
    {
        $index = Product::where('isActive', true)->first();
        $data = [
            'status' => true,
            'message' => 'Here are your product items',
            'title'=>$index->title->name,
            'data' => $index
        ];
        return response()->json($data, 200);
    }

    public function deleteProduct(Request $request, $id)
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

    public function updateProduct(Request $request, $id)
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

    public function productItemList()
    {
        $index = Product::first();

        $data = [
            'status' => true,
            'message' => "Here are product:",
            'title'=>$index->title->name,
            'data' => $index
        ];
        return response()->json($data);
    }

    //pannel
    public function createPanel(Request $request)
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

    public function allPanel()
    {
        $index = Panel::where('isActive', true)->first();
        $data = [
            'status' => true,
            'message' => 'Here are your index items',
            'title'=>$index->title->name,
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
    public function createCompleteSolutionProvider(Request $request)
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

    public function detailsCompleteSolutionProvider()
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

    public function updateCompleteSolutionProvider(Request $request, $id)
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

    public function deleteCompleteSolutionProvider(Request $request, $id)
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

    //Edu
    public function createEducation(Request $request)
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

        $existingPanel = Education::where('header_title', $request->input('header_title'))->first();
        if ($existingPanel) {
            return response()->json([
                'status' => false,
                'message' => 'Panel with the same title_id already exists',
                'data' => [],
            ], 409);
        }

        $index = new Education();
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

    public function updateEducation(Request $request, $id)
    {
        $index = Education::find($id);
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
            'header_title' => $request->header_title,
            'heading_description' => $request->heading_description,
            'title' => $request->title,
            'description' => $request->description,
            'button_link' => $request->button_link,
            'button_text' => $request->button_text,
            'isActive' => $request->isActive
        ]);

        $all_data = [
            'header_title' => $index->title,
            'heading_description' => $index->heading_description,
            'image' => $index->image,
            'title' => $index->title,
            'description' => $index->description,
            'button_link' => $index->button_link,
            'button_text' => $index->button_text,
            'isActive' => $index->isActive
        ];

        $data = [
            'status' => 200,
            'message' => "Edu updated successfully",
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function showEducation()
    {
        $index = Education::where('isActive', true)->first();

        $data = [
            'status' => true,
            'message' => 'Here are your Edu items',
            'header_title' => $index->title,
            'data' => $index,
        ];
        return response()->json($data, 200);
    }

    //Feature products
    public function CreateFeatureProduct(Request $request)
    {
        $rules = array(
            'title_id' => 'required',
            'description' => 'required',
            'master_image' => 'required',
            'left_image' => 'required',
            'right_image' => 'required',
            'caption' => 'required',
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

        if ($request->input('title_id') != 5) {
            return response()->json([
                'status' => false,
                'message' => 'Feature can only be created with header_title equal to 5',
                'data' => [],
            ], 400);
        }

        $existingPanel = FeatureProduct::where('title_id', $request->input('title_id'))->first();
        if ($existingPanel) {
            return response()->json([
                'status' => false,
                'message' => 'Feature product with the same title_id already exists',
                'data' => [],
            ], 409);
        }

        $index = new FeatureProduct();
        if ($panelimage = $request->file('master_image')) {
            $imageName1 = time() . '-' . uniqid() . '.' . $panelimage->getClientOriginalExtension();
            $panelimage->move(public_path('featureProduct'), $imageName1);
        }

        if ($panelimage1 = $request->file('left_image')) {
            $imageName2 = time() . '-' . uniqid() . '.' . $panelimage1->getClientOriginalExtension();
            $panelimage1->move(public_path('featureProduct'), $imageName2);
        }

        if ($panelimage2 = $request->file('right_image')) {
            $imageName3 = time() . '-' . uniqid() . '.' . $panelimage2->getClientOriginalExtension();
            $panelimage2->move(public_path('featureProduct'), $imageName3);
        }

        $index->title_id = $request->title_id;
        $index->description = $request->description;
        $index->master_image = $imageName1;
        $index->left_image = $imageName2;
        $index->right_image = $imageName3;
        $index->caption = $request->caption;
        $index->button_text = $request->button_text;
        $index->button_link = $request->button_link;
        $index->save();

        if ($index->save()) {
            $data = [
                'status' => true,
                'message' => 'Feature products successfully created',
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

    public function UpdateFeatureProduct(Request $request, $id)
    {
        $index = FeatureProduct::find($id);
        if (!$index) {
            return response()->json([
                'status' => false,
                'message' => 'Feature product not found',
            ], 404);
        }

        if ($image1 = $request->file('master_image')) {
            if ($index->master_image && file_exists(public_path('featureProduct') . '/' . $index->master_image)) {
                unlink(public_path('featureProduct') . '/' . $index->master_image);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('featureProduct'), $imageName1);

            $index->update([
                'master_image' => $imageName1,
            ]);
        }

        if ($image2 = $request->file('left_image')) {
            if ($index->left_image && file_exists(public_path('featureProduct') . '/' . $index->left_image)) {
                unlink(public_path('featureProduct') . '/' . $index->left_image);
            }

            $imageName2 = time() . '-' . uniqid() . '.' . $image2->getClientOriginalExtension();
            $image2->move(public_path('featureProduct'), $imageName2);

            $index->update([
                'left_image' => $imageName2,
            ]);
        }

        if ($image3 = $request->file('right_image')) {
            if ($index->right_image && file_exists(public_path('featureProduct') . '/' . $index->right_image)) {
                unlink(public_path('featureProduct') . '/' . $index->right_image);
            }

            $imageName3 = time() . '-' . uniqid() . '.' . $image3->getClientOriginalExtension();
            $image3->move(public_path('featureProduct'), $imageName3);

            $index->update([
                'right_image' => $imageName3,
            ]);
        }

        $index->update([
            'title_id' => $request->title_id,
            'description' => $request->description,
            'caption' => $request->caption,
            'button_link' => $request->button_link,
            'button_text' => $request->button_text,
            'isActive' => $request->isActive
        ]);

        $all_data = [
            'description' => $index->description,
            'button_link' => $index->button_link,
            'button_text' => $index->button_text,
            'isActive' => $index->isActive
        ];

        $data = [
            'status' => 200,
            'message' => "Feature product updated successfully",
            'title' => $index->title->name,
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function FeatureProductDetails()
    {
        $pro = FeatureProduct::where('isActive', true)->first();

        $data = [
            'status' => true,
            'message' => 'Here feature product details',
            'title_id' => $pro->title->name,
            'data' => $pro,

        ];
        return response()->json($data, 200);
    }

    //Confirences
    public function CreateConference(Request $request)
    {
        $rules = array(
            'title_id' => 'required',
            'master_image' => 'required',
            'sub_image1' => 'required',
            'sub_image2' => 'required',
            'sub_image3' => 'required',
            'sub_image4' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 403);
        }

        if ($request->input('title_id') != 6) {
            return response()->json([
                'status' => false,
                'message' => 'Conference can only be created with header_title equal to 6',
                'data' => [],
            ], 400);
        }

        $existingPanel = Conference::where('title_id', $request->input('title_id'))->first();
        if ($existingPanel) {
            return response()->json([
                'status' => false,
                'message' => 'Conference with the same title_id already exists',
                'data' => [],
            ], 409);
        }

        $index = new Conference();
        if ($panelimage = $request->file('master_image')) {
            $imageName1 = time() . '-' . uniqid() . '.' . $panelimage->getClientOriginalExtension();
            $panelimage->move(public_path('conference'), $imageName1);
        }

        if ($panelimage1 = $request->file('sub_image1')) {
            $imageName2 = time() . '-' . uniqid() . '.' . $panelimage1->getClientOriginalExtension();
            $panelimage1->move(public_path('conference'), $imageName2);
        }

        if ($panelimage2 = $request->file('sub_image2')) {
            $imageName3 = time() . '-' . uniqid() . '.' . $panelimage2->getClientOriginalExtension();
            $panelimage2->move(public_path('conference'), $imageName3);
        }

        if ($panelimage3 = $request->file('sub_image3')) {
            $imageName4 = time() . '-' . uniqid() . '.' . $panelimage3->getClientOriginalExtension();
            $panelimage3->move(public_path('conference'), $imageName4);
        }

        if ($panelimage4 = $request->file('sub_image4')) {
            $imageName5 = time() . '-' . uniqid() . '.' . $panelimage4->getClientOriginalExtension();
            $panelimage4->move(public_path('conference'), $imageName5);
        }

        $index->title_id = $request->title_id;
        $index->master_image = $imageName1;
        $index->sub_image1 = $imageName2;
        $index->sub_image2 = $imageName3;
        $index->sub_image3 = $imageName4;
        $index->sub_image4 = $imageName5;
        $index->save();

        if ($index->save()) {
            $data = [
                'status' => true,
                'message' => 'Conference successfully created',
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

    public function UpdateConference(Request $request, $id)
    {
        $index = Conference::find($id);
        if (!$index) {
            return response()->json([
                'status' => false,
                'message' => 'Conference not found',
            ], 404);
        }

        if ($image1 = $request->file('master_image')) {
            if ($index->master_image && file_exists(public_path('conference') . '/' . $index->master_image)) {
                unlink(public_path('conference') . '/' . $index->master_image);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('conference'), $imageName1);

            $index->update([
                'master_image' => $imageName1,
            ]);
        }

        if ($image2 = $request->file('sub_image1')) {
            if ($index->sub_image1 && file_exists(public_path('conference') . '/' . $index->sub_image1)) {
                unlink(public_path('conference') . '/' . $index->sub_image1);
            }

            $imageName2 = time() . '-' . uniqid() . '.' . $image2->getClientOriginalExtension();
            $image2->move(public_path('conference'), $imageName2);

            $index->update([
                'sub_image1' => $imageName2,
            ]);
        }

        if ($image3 = $request->file('sub_image2')) {
            if ($index->sub_image2 && file_exists(public_path('conference') . '/' . $index->sub_image2)) {
                unlink(public_path('conference') . '/' . $index->sub_image2);
            }

            $imageName3 = time() . '-' . uniqid() . '.' . $image3->getClientOriginalExtension();
            $image3->move(public_path('conference'), $imageName3);

            $index->update([
                'sub_image2' => $imageName3,
            ]);
        }

        if ($image4 = $request->file('sub_image3')) {
            if ($index->sub_image3 && file_exists(public_path('conference') . '/' . $index->sub_image3)) {
                unlink(public_path('conference') . '/' . $index->sub_image3);
            }

            $imageName4 = time() . '-' . uniqid() . '.' . $image4->getClientOriginalExtension();
            $image4->move(public_path('conference'), $imageName4);

            $index->update([
                'sub_image3' => $imageName4,
            ]);
        }

        if ($image5 = $request->file('sub_image4')) {
            if ($index->sub_image4 && file_exists(public_path('conference') . '/' . $index->sub_image4)) {
                unlink(public_path('conference') . '/' . $index->sub_image4);
            }

            $imageName5 = time() . '-' . uniqid() . '.' . $image5->getClientOriginalExtension();
            $image5->move(public_path('conference'), $imageName5);

            $index->update([
                'sub_image4' => $imageName5,
            ]);
        }

        $index->update([
            'title_id' => $request->title_id,
            'isActive' => $request->isActive
        ]);

        $all_data = [
            'title_id' => $index->title_id,
            'isActive' => $index->isActive
        ];

        $data = [
            'status' => 200,
            'message' => "Conference updated successfully",
            'title' => $index->title->name,
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function ConferenceDetails()
    {
        $pro = Conference::where('isActive', true)->first();

        $data = [
            'status' => true,
            'message' => 'Here feature product details',
            'title_id' => $pro->title->name,
            'data' => $pro,

        ];
        return response()->json($data, 200);
    }

    //Honorable Clent
    public function createHonorableClient(Request $request)
    {
        $rules = array(
            'title_id' => 'required',
            'image' => 'required',
            'link' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 403);
        }

        if ($request->input('title_id') != 7) {
            return response()->json([
                'status' => false,
                'message' => 'Feature can only be created with header_title equal to 7',
                'data' => [],
            ], 400);
        }
        $index = new HonorableClient();
        if ($panelimage = $request->file('image')) {
            $imageName1 = time() . '-' . uniqid() . '.' . $panelimage->getClientOriginalExtension();
            $panelimage->move(public_path('honorable_client'), $imageName1);
        }

        $index->title_id = $request->title_id;
        $index->description = $request->description;
        $index->image = $imageName1;
        $index->link = $request->link;

        $index->save();

        if ($index->save()) {
            $data = [
                'status' => true,
                'message' => 'Honorable client successfully created',
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

    public function updateHonorableClient(Request $request, $id)
    {
        $index = HonorableClient::find($id);
        if (!$index) {
            return response()->json([
                'status' => false,
                'message' => 'Client id not found',
            ], 404);
        }

        if ($image1 = $request->file('image')) {
            if ($index->image && file_exists(public_path('honorable_client') . '/' . $index->image)) {
                unlink(public_path('honorable_client') . '/' . $index->image);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('honorable_client'), $imageName1);

            $index->update([
                'image' => $imageName1,
            ]);
        }
        $index->update([
            'title_id' => $request->title_id,
            'description' => $request->description,
            'link' => $request->link,
            'isActive' => $request->isActive
        ]);

        $all_data = [
            'image' => $index->image,
            'description' => $index->description,
            'link' => $index->button_link,
            'isActive' => $index->isActive
        ];

        $data = [
            'status' => 200,
            'message' => "Client updated successfully",
            'title' => $index->title->name,
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function honorableClientDetails()
    {
        $csps = HonorableClient::where('isActive', true)
            ->select(['title_id', 'image', 'description', 'link', 'isActive'])
            ->get();

        $formattedCsps = [];

        foreach ($csps as $csp) {
            $formattedCsps[] = [
                'title_id' => $csp->title_id,
                'image' => $csp->image,
                'description' => $csp->description,
                'link' => $csp->link,
                'isActive' => $csp->isActive

            ];
        }

        $firstCspTitle = $csps->first()->title->name;

        $data = [
            'status' => true,
            'message' => 'Here are your client list:',
            'title' => $firstCspTitle,
            'data' => $formattedCsps
        ];

        return response()->json($data, 200);
    }

    //Our teams
    public function createOurTeam(Request $request)
    {
        $rules = array(
            'title_id' => 'required',
            'name' => 'required',
            'image' => 'required',
            'department' => 'required',
            'designation' => 'required',
            'sequence' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 403);
        }

        if ($request->input('title_id') != 8) {
            return response()->json([
                'status' => false,
                'message' => 'Feature can only be created with header_title equal to 8',
                'data' => [],
            ], 400);
        }

        $existingsequence = OurTeam::where('sequence', $request->input('sequence'))->first();
        if ($existingsequence) {
            return response()->json([
                'status' => false,
                'message' => 'Same number already existed',
                'data' => [],
            ], 409);
        }

        $index = new OurTeam();
        if ($panelimage = $request->file('image')) {
            $imageName1 = time() . '-' . uniqid() . '.' . $panelimage->getClientOriginalExtension();
            $panelimage->move(public_path('Our team'), $imageName1);
        }

        $index->title_id = $request->title_id;
        $index->name = $request->name;
        $index->image = $imageName1;
        $index->department = $request->department;
        $index->designation = $request->designation;
        $index->sequence = $request->sequence;

        $index->save();

        if ($index->save()) {
            $data = [
                'status' => true,
                'message' => 'Teams successfully created',
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

    public function updateOurTeam(Request $request, $id)
    {
        $index = OurTeam::find($id);
        if (!$index) {
            return response()->json([
                'status' => false,
                'message' => 'Team member id not found',
            ], 404);
        }

        if ($image1 = $request->file('image')) {
            if ($index->image && file_exists(public_path('Our team') . '/' . $index->image)) {
                unlink(public_path('Our team') . '/' . $index->image);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('Our team'), $imageName1);

            $index->update([
                'image' => $imageName1,
            ]);
        }
        $index->update([
            'title_id' => $request->title_id,
            'name' => $request->name,
            'department' => $request->department,
            'designation' => $request->designation,
            'sequence' => $request->sequence,
            'isActive' => $request->isActive
        ]);

        $all_data = [
            'image' => $index->image,
            'name' => $index->name,
            'department' => $index->department,
            'designation' => $index->designation,
            'sequence' => $index->sequence,
            'isActive' => $index->isActive
        ];

        $data = [
            'status' => 200,
            'message' => "Team member updated successfully",
            'title' => $index->title->name,
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function ourTeamMemberList()
    {
        $csps = OurTeam::where('isActive', true)
            ->select(['title_id', 'name', 'image', 'department', 'designation', 'sequence', 'isActive'])
            ->orderBy('sequence', 'ASC')
            ->get();

        $formattedCsps = [];

        foreach ($csps as $csp) {
            $formattedCsps[] = [
                'title_id' => $csp->title_id,
                'name' => $csp->name,
                'image' => $csp->image,
                'department' => $csp->department,
                'designation' => $csp->designation,
                'sequence' => $csp->sequence,
                'isActive' => $csp->isActive

            ];
        }

        $firstCspTitle = $csps->first()->title->name;

        $data = [
            'status' => true,
            'message' => 'Here are our team member list:',
            'title' => $firstCspTitle,
            'data' => $formattedCsps
        ];

        return response()->json($data, 200);
    }

    //Case Studies
    public function createCaseStudies(Request $request)
    {
        $rules = array(
            'title_id' => 'required',
            'title_name' => 'required',
            'description' => 'required'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 403);
        }

        if ($request->input('title_id') != 9) {
            return response()->json([
                'status' => false,
                'message' => 'Case studies can only be created with header_title equal to 9',
                'data' => [],
            ], 400);
        }

        $index = new CaseStudy();


        $index->title_id = $request->title_id;
        $index->title_name = $request->title_name;
        $index->description = $request->description;
        $index->save();

        if ($index->save()) {
            $data = [
                'status' => true,
                'message' => 'Case studies successfully created',
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

    public function updateCaseStudies(Request $request, $id)
    {
        $index = CaseStudy::find($id);
        if (!$index) {
            return response()->json([
                'status' => false,
                'message' => 'Case is not found',
            ], 404);
        }
        $index->update([
            'title_id' => $request->title_id,
            'title' => $request->title,
            'description' => $request->description,
            'isActive' => $request->isActive
        ]);

        $all_data = [
            'title' => $index->title,
            'description' => $index->description,
            'isActive' => $index->isActive
        ];

        $data = [
            'status' => 200,
            'message' => "Case studies updated successfully",
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function caseStudyList()
    {
        $cases = CaseStudy::where('isActive', true)
            ->select(['title_id', 'title_name', 'description', 'isActive'])
            ->get();

        $formattedcase = [];

        foreach ($cases as $case) {
            $formattedcase[] = [
                'title_id' => $case->title_id,
                'title_name' => $case->title_name,
                'description' => $case->description,
                'isActive' => $case->isActive

            ];
        }

        $title_id = $cases->first()->title->name;

        $data = [
            'status' => true,
            'message' => 'Here are our team member list:',
            'title' => $title_id,
            'data' => $formattedcase
        ];

        return response()->json($data, 200);
    }

    //Testimonial
    public function createTestimonial(Request $request)
    {
        $rules = array(
            'title_id' => 'required',
            'subtitle_id' => 'required',
            'image' => 'required',
            'name' => 'required',
            'designation' => 'required',
            'review' => 'required',
            'feed_back' => 'required'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 403);
        }

        if ($request->input('title_id') != 10) {
            return response()->json([
                'status' => false,
                'message' => 'Testimonial can only be created with header_title equal to 10',
                'data' => [],
            ], 400);
        }
        $index = new Testimonial();
        if ($panelimage = $request->file('image')) {
            $imageName1 = time() . '-' . uniqid() . '.' . $panelimage->getClientOriginalExtension();
            $panelimage->move(public_path('Testimonial'), $imageName1);
        }

        $index->title_id = $request->title_id;
        $index->subtitle_id = $request->subtitle_id;
        $index->name = $request->name;
        $index->image = $imageName1;
        $index->designation = $request->designation;
        $index->review = $request->review;
        $index->feed_back = $request->feed_back;
        $index->save();

        if ($index->save()) {
            $data = [
                'status' => true,
                'message' => 'Testimonial successfully created',
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

    public function updateTestimonial(Request $request, $id)
    {
        $index = Testimonial::find($id);
        if (!$index) {
            return response()->json([
                'status' => false,
                'message' => 'Testimonial id not found',
            ], 404);
        }

        if ($image1 = $request->file('image')) {
            if ($index->image && file_exists(public_path('Testimonial') . '/' . $index->image)) {
                unlink(public_path('Testimonial') . '/' . $index->image);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('Testimonial'), $imageName1);

            $index->update([
                'image' => $imageName1,
            ]);
        }
        $index->update([
            'title_id' => $request->title_id,
            'sub_title_id'=>$request->sub_title_id,
            'name' => $request->name,
            'designation'=>$request->designation,
            'review'=>$request->review,
            'feed_back'=>$request->feed_back,
            'isActive' => $request->isActive
        ]);

        $all_data = [
            'title' => $index->title->name,
            'sub_title'=>$index->subtitle->name,
            'name' => $index->name,
            'review' => $index->review,
            'isActive' => $index->isActive
        ];

        $data = [
            'status' => 200,
            'message' => "Testimonial updated successfully",
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function testimonialList()
    {
        $cases = Testimonial::where('isActive', true)
            ->select(['title_id', 'subtitle_id','name','image','review','feed_back','isActive'])
            ->get();

        $formattedcase = [];

        foreach ($cases as $case) {
            $formattedcase[] = [
                'title_id' => $case->title_id,
                'subtitle_id' => $case->subtitle_id,
                'name' => $case->name,
                'image'=>$case->image,
                'review'=>$case->review,
                'feed_back'=>$case->feed_back,
                'isActive' => $case->isActive
            ];
        }

        $title_id = $cases->first()->title->name;
        $subtitle=$cases->first()->subtitle->name;
        $data = [
            'status' => true,
            'message' => 'Here are our team member list:',
            'title' => $title_id,
            'sub_tilte'=>$subtitle,
            'data' => $formattedcase
        ];

        return response()->json($data, 200);
    }
    
}
