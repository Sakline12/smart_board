<?php

namespace App\Http\Controllers;

use App\Models\CaseStudy;
use App\Models\CompleteSolutionProvider;
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
        $validator = Validator::make($request->all(), [
            'image' => 'required',
            'title' => 'required',
            'content' =>  'required',
            'button_text' => 'required',
            'button_link' => 'required',
        ]);

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
        $index = IndexSlider::where('is_active', true)->get();
        if ($index) {
            $data = [
                'status' => true,
                'message' => 'Here are your index items',
                'data' => $index
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => false,
                'message' => 'Data is not active',
                'data' => []
            ];
            return response()->json($data, 404);
        }
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
            'is_active' => $request->is_active,
        ]);

        $all_data = [
            'image' => $index->image,
            'title' => $index->title,
            'content' => $index->content,
            'button_text' => $index->button_text,
            'is_active' => $index->is_active,
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
        $index = IndexSlider::get();
        $data = [
            'status' => true,
            'message' => 'Here are your index items',
            'data' => $index
        ];
        return response()->json($data, 200);
    }

    //Product
    public function createProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_id' => 'required',
            'product_image' =>  'required',
            'background_img' => 'required',
        ]);

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
        $index = Product::where('is_active', true)->first();
        if ($index) {
            $data = [
                'status' => true,
                'message' => 'Here are your product items',
                'title' => $index->title->name,
                'data' => $index
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => false,
                'message' => 'Data is not active',
                'data' => []
            ];
            return response()->json($data, 404);
        }
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
            'title_id' => $request->title_id,
            'is_active' => $request->is_active
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
            'title' => $index->title->name,
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
        $index = Panel::where('is_active', true)->first();
        if ($index) {
            $data = [
                'status' => true,
                'message' => 'Here are your index items',
                'title' => $index->title->name,
                'data' => $index
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => false,
                'message' => 'Data is not active',
                'data' => []
            ];
            return response()->json($data, 404);
        }
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
            'is_active' => $request->is_active
        ]);

        $data = [
            'title_id' => $index->title_id,
            'description' => $index->description,
            'is_active' => $index->is_active,
        ];

        $data = [
            'status' => 200,
            'message' => "Panel updated successfully",
            'data' => $data,
        ];

        return response()->json($data);
    }

    public function panelList()
    {
        $panel = Panel::first();
        $data = [
            'status' => true,
            'message' => "Here are all panel items:",
            'data' => $panel
        ];
        return response()->json($data);
    }

    //Complete Solution Provider
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

        $completesolutionprovider = new CompleteSolutionProvider();
        $completesolutionprovider->title_id = $request->title_id;
        $completesolutionprovider->image = $imageName;
        $completesolutionprovider->subtitle = $request->subtitle;
        $completesolutionprovider->description = $request->description;
        $completesolutionprovider->button_text = $request->button_text;
        $completesolutionprovider->button_link = $request->button_link;
        $completesolutionprovider->save();

        if ($completesolutionprovider) {
            $data = [
                'status' => true,
                'message' => 'CompleteSolutionProvider successfully created',
                'data' => $completesolutionprovider,
            ];
            return response()->json($data, 201);
        } else {
            $data = [
                'status' => false,
                'message' => 'Error occurred',
                'data' => [
                    'title_name' => $completesolutionprovider->title->title_id,
                ],
            ];
            return response()->json($data, 500);
        }
    }

    public function infoCompleteSolutionProvider()
    {
        $completesolutionproviders = CompleteSolutionProvider::where('is_active', true)
            ->select(['title_id', 'image', 'subtitle', 'description', 'button_text', 'button_link'])
            ->get();

        $formattedcompletesolutionproviders = [];

        foreach ($completesolutionproviders as $completesolutionprovider) {
            $formattedcompletesolutionproviders[] = [
                'image' => $completesolutionprovider->image,
                'subtitle' => $completesolutionprovider->subtitle,
                'description' => $completesolutionprovider->description,
                'button_text' => $completesolutionprovider->button_text,
                'button_link' => $completesolutionprovider->button_link,
            ];
        }

        $firstcompletesolutionproviderTitle = $completesolutionproviders->first()->title->name;

        $data = [
            'status' => true,
            'message' => 'Here are your completesolutionprovider items',
            'title' => $firstcompletesolutionproviderTitle,
            'data' => $formattedcompletesolutionproviders
        ];

        return response()->json($data, 200);
    }

    public function detailsCompleteSolutionProvider()
    {
        $completesolutionproviders = CompleteSolutionProvider::select(['title_id', 'image', 'subtitle', 'description', 'button_text', 'button_link', 'is_active'])
            ->get();

        $formattedcompletesolutionproviders = [];

        foreach ($completesolutionproviders as $completesolutionprovider) {
            $formattedcompletesolutionproviders[] = [
                'image' => $completesolutionprovider->image,
                'subtitle' => $completesolutionprovider->subtitle,
                'description' => $completesolutionprovider->description,
                'button_text' => $completesolutionprovider->button_text,
                'button_link' => $completesolutionprovider->button_link,
                'is_active' => $completesolutionprovider->is_active,
            ];
        }

        $firstcompletesolutionproviderTitle = $completesolutionproviders->first()->title->name;

        $data = [
            'status' => true,
            'message' => 'Here are your completesolutionprovider items',
            'title' => $firstcompletesolutionproviderTitle,
            'data' => $formattedcompletesolutionproviders
        ];

        return response()->json($data, 200);
    }

    public function updateCompleteSolutionProvider(Request $request, $id)
    {
        $completesolutionprovider = CompleteSolutionProvider::find($id);
        if (!$completesolutionprovider) {
            return response()->json([
                'status' => false,
                'message' => 'CSP items not found',
            ], 404);
        }

        if ($image1 = $request->file('image')) {
            if ($completesolutionprovider->image && file_exists(public_path('csp') . '/' . $completesolutionprovider->image)) {
                unlink(public_path('csp') . '/' . $completesolutionprovider->image);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('csp'), $imageName1);

            $completesolutionprovider->update([
                'image' => $imageName1,
            ]);
        }
        $completesolutionprovider->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'button_link' => $request->button_link,
            'button_text' => $request->button_text,
            'is_active' => $request->is_active
        ]);

        $all_data = [
            'subtitle' => $completesolutionprovider->subtitle,
            'image' => $completesolutionprovider->image,
            'description' => $completesolutionprovider->description,
            'button_link' => $completesolutionprovider->button_link,
            'button_text' => $completesolutionprovider->button_text,
            'is_active' => $completesolutionprovider->is_active
        ];

        $data = [
            'status' => 200,
            'message' => "Product updated successfully",
            'title' => $completesolutionprovider->title->name,
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function deleteCompleteSolutionProvider(Request $request, $id)
    {
        $index = CompleteSolutionProvider::where('id', $id)->delete();
        if ($index) {
            $data = [
                'status' => true,
                'message' => 'Delete this complete solution provider successfully',
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

    //Education
    public function createEducation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'header_title' => 'required',
            'heading_description' => 'required',
            'image' => 'required',
            'title' => 'required',
            'description' => 'required',
            'button_text' => 'required',
            'button_link' => 'required',
        ]);

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

        $education = new Education();
        if ($panelimage = $request->file('image')) {
            $imageName1 = time() . '-' . uniqid() . '.' . $panelimage->getClientOriginalExtension();
            $panelimage->move(public_path('edu'), $imageName1);
        }

        $education->header_title = $request->input('header_title');
        $education->heading_description = $request->input('heading_description');
        $education->image = $imageName1;
        $education->title = $request->input('title');
        $education->description = $request->input('description');
        $education->button_text = $request->input('button_text');
        $education->button_link = $request->input('button_link');
        $education->save();

        if ($education->save()) {
            $data = [
                'status' => true,
                'message' => 'Edu successfully created',
                'data' => $education,
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
        $education = Education::find($id);
        if (!$education) {
            return response()->json([
                'status' => false,
                'message' => 'Edu items not found',
            ], 404);
        }

        if ($image1 = $request->file('image')) {
            if ($education->image && file_exists(public_path('edu') . '/' . $education->image)) {
                unlink(public_path('edu') . '/' . $education->image);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('edu'), $imageName1);

            $education->update([
                'image' => $imageName1,
            ]);
        }
        $education->update([
            'header_title' => $request->header_title,
            'heading_description' => $request->heading_description,
            'title' => $request->title,
            'description' => $request->description,
            'button_link' => $request->button_link,
            'button_text' => $request->button_text,
            'is_active' => $request->is_active
        ]);

        $all_data = [
            'header_title' => $education->title,
            'heading_description' => $education->heading_description,
            'image' => $education->image,
            'title' => $education->title,
            'description' => $education->description,
            'button_link' => $education->button_link,
            'button_text' => $education->button_text,
            'is_active' => $education->is_active
        ];

        $data = [
            'status' => 200,
            'message' => "Edu updated successfully",
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function educationDetails()
    {
        $index = Education::where('is_active', true)->first();
        if ($index) {
            $data = [
                'status' => true,
                'message' => 'Here are your Edu items',
                'header_title' => $index->title,
                'data' => $index,
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => false,
                'message' => 'Data is not active',
                'data' => $index,
            ];
            return response()->json($data, 404);
        }
    }

    public function educationInfo()
    {
        $index = Education::first();
        if ($index) {
            $data = [
                'status' => true,
                'message' => 'Here are your Education items',
                'header_title' => $index->title,
                'data' => $index,
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


    //Feature products
    public function createFeatureProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_id' => 'required',
            'description' => 'required',
            'master_image' => 'required',
            'left_image' => 'required',
            'right_image' => 'required',
            'caption' => 'required',
            'button_text' => 'required',
            'button_link' => 'required',
        ]);

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

        $feature = new FeatureProduct();
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

        $feature->title_id = $request->title_id;
        $feature->description = $request->description;
        $feature->master_image = $imageName1;
        $feature->left_image = $imageName2;
        $feature->right_image = $imageName3;
        $feature->caption = $request->caption;
        $feature->button_text = $request->button_text;
        $feature->button_link = $request->button_link;
        $feature->save();

        if ($feature->save()) {
            $data = [
                'status' => true,
                'message' => 'Feature products successfully created',
                'data' => $feature,
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

    public function updateFeatureProduct(Request $request, $id)
    {
        $feature = FeatureProduct::find($id);
        if (!$feature) {
            return response()->json([
                'status' => false,
                'message' => 'Feature product not found',
            ], 404);
        }

        if ($image1 = $request->file('master_image')) {
            if ($feature->master_image && file_exists(public_path('featureProduct') . '/' . $feature->master_image)) {
                unlink(public_path('featureProduct') . '/' . $feature->master_image);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('featureProduct'), $imageName1);

            $feature->update([
                'master_image' => $imageName1,
            ]);
        }

        if ($image2 = $request->file('left_image')) {
            if ($feature->left_image && file_exists(public_path('featureProduct') . '/' . $feature->left_image)) {
                unlink(public_path('featureProduct') . '/' . $feature->left_image);
            }

            $imageName2 = time() . '-' . uniqid() . '.' . $image2->getClientOriginalExtension();
            $image2->move(public_path('featureProduct'), $imageName2);

            $feature->update([
                'left_image' => $imageName2,
            ]);
        }

        if ($image3 = $request->file('right_image')) {
            if ($feature->right_image && file_exists(public_path('featureProduct') . '/' . $feature->right_image)) {
                unlink(public_path('featureProduct') . '/' . $feature->right_image);
            }

            $imageName3 = time() . '-' . uniqid() . '.' . $image3->getClientOriginalExtension();
            $image3->move(public_path('featureProduct'), $imageName3);

            $feature->update([
                'right_image' => $imageName3,
            ]);
        }

        $feature->update([
            'title_id' => $request->title_id,
            'description' => $request->description,
            'caption' => $request->caption,
            'button_link' => $request->button_link,
            'button_text' => $request->button_text,
            'is_active' => $request->is_active
        ]);

        $all_data = [
            'description' => $feature->description,
            'button_link' => $feature->button_link,
            'button_text' => $feature->button_text,
            'is_active' => $feature->is_active
        ];

        $data = [
            'status' => 200,
            'message' => "Feature product updated successfully",
            'title' => $feature->title->name,
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function featureProductDetails()
    {
        $feature = FeatureProduct::first();
        $data = [
            'status' => true,
            'message' => 'Here feature product details',
            'title_id' => $feature->title->name,
            'data' => $feature,

        ];
        return response()->json($data, 200);
    }

    public function featureInfo()
    {
        $feature = FeatureProduct::where('is_active', true)->first();

        if ($feature) {
            $data = [
                'status' => true,
                'message' => 'Here feature product details',
                'title_id' => $feature->title->name,
                'data' => $feature,

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

    //Confirences
    public function CreateConference(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title_id' => 'required',
            'master_image' => 'required',
            'sub_image1' => 'required',
            'sub_image2' => 'required',
            'sub_image3' => 'required',
            'sub_image4' => 'required',
        ]);

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

        $conference = new Conference();
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

        $conference->title_id = $request->title_id;
        $conference->master_image = $imageName1;
        $conference->sub_image1 = $imageName2;
        $conference->sub_image2 = $imageName3;
        $conference->sub_image3 = $imageName4;
        $conference->sub_image4 = $imageName5;
        $conference->save();

        if ($conference->save()) {
            $data = [
                'status' => true,
                'message' => 'Conference successfully created',
                'data' => $conference,
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
        $conference = Conference::find($id);
        if (!$conference) {
            return response()->json([
                'status' => false,
                'message' => 'Conference not found',
            ], 404);
        }

        if ($image1 = $request->file('master_image')) {
            if ($conference->master_image && file_exists(public_path('conference') . '/' . $conference->master_image)) {
                unlink(public_path('conference') . '/' . $conference->master_image);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('conference'), $imageName1);

            $conference->update([
                'master_image' => $imageName1,
            ]);
        }

        if ($image2 = $request->file('sub_image1')) {
            if ($conference->sub_image1 && file_exists(public_path('conference') . '/' . $conference->sub_image1)) {
                unlink(public_path('conference') . '/' . $conference->sub_image1);
            }

            $imageName2 = time() . '-' . uniqid() . '.' . $image2->getClientOriginalExtension();
            $image2->move(public_path('conference'), $imageName2);

            $conference->update([
                'sub_image1' => $imageName2,
            ]);
        }

        if ($image3 = $request->file('sub_image2')) {
            if ($conference->sub_image2 && file_exists(public_path('conference') . '/' . $conference->sub_image2)) {
                unlink(public_path('conference') . '/' . $conference->sub_image2);
            }

            $imageName3 = time() . '-' . uniqid() . '.' . $image3->getClientOriginalExtension();
            $image3->move(public_path('conference'), $imageName3);

            $conference->update([
                'sub_image2' => $imageName3,
            ]);
        }

        if ($image4 = $request->file('sub_image3')) {
            if ($conference->sub_image3 && file_exists(public_path('conference') . '/' . $conference->sub_image3)) {
                unlink(public_path('conference') . '/' . $conference->sub_image3);
            }

            $imageName4 = time() . '-' . uniqid() . '.' . $image4->getClientOriginalExtension();
            $image4->move(public_path('conference'), $imageName4);

            $conference->update([
                'sub_image3' => $imageName4,
            ]);
        }

        if ($image5 = $request->file('sub_image4')) {
            if ($conference->sub_image4 && file_exists(public_path('conference') . '/' . $conference->sub_image4)) {
                unlink(public_path('conference') . '/' . $conference->sub_image4);
            }

            $imageName5 = time() . '-' . uniqid() . '.' . $image5->getClientOriginalExtension();
            $image5->move(public_path('conference'), $imageName5);

            $conference->update([
                'sub_image4' => $imageName5,
            ]);
        }

        $conference->update([
            'title_id' => $request->title_id,
            'is_active' => $request->is_active
        ]);

        $all_data = [
            'title_id' => $conference->title_id,
            'is_active' => $conference->is_active
        ];

        $data = [
            'status' => 200,
            'message' => "Conference updated successfully",
            'title' => $conference->title->name,
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function ConferenceDetails()
    {
        $conference = Conference::where('is_active', true)->first();
        if ($conference) {
            $data = [
                'status' => true,
                'message' => 'Here feature product details',
                'title_id' => $conference->title->name,
                'data' => $conference,

            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => False,
                'message' => 'Data is not active',
                'data' => [],

            ];
            return response()->json($data, 404);
        }
    }

    public function conferenceInfo()
    {
        $conference = Conference::first();

        $data = [
            'status' => true,
            'message' => 'Here feature product details',
            'title_id' => $conference->title->name,
            'data' => $conference,

        ];
        return response()->json($data, 200);
    }


    //Honorable Clent
    public function createHonorableClient(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title_id' => 'required',
            'image' => 'required',
            'link' => 'required',
        ]);

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
        $client = new HonorableClient();
        if ($panelimage = $request->file('image')) {
            $imageName1 = time() . '-' . uniqid() . '.' . $panelimage->getClientOriginalExtension();
            $panelimage->move(public_path('honorable_client'), $imageName1);
        }

        $client->title_id = $request->title_id;
        $client->description = $request->description;
        $client->image = $imageName1;
        $client->link = $request->link;

        $client->save();

        if ($client->save()) {
            $data = [
                'status' => true,
                'message' => 'Honorable client successfully created',
                'data' => $client,
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
        $client = HonorableClient::find($id);
        if (!$client) {
            return response()->json([
                'status' => false,
                'message' => 'Client id not found',
            ], 404);
        }

        if ($image1 = $request->file('image')) {
            if ($client->image && file_exists(public_path('honorable_client') . '/' . $client->image)) {
                unlink(public_path('honorable_client') . '/' . $client->image);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('honorable_client'), $imageName1);

            $client->update([
                'image' => $imageName1,
            ]);
        }
        $client->update([
            'title_id' => $request->title_id,
            'description' => $request->description,
            'link' => $request->link,
            'is_active' => $request->is_active
        ]);

        $all_data = [
            'image' => $client->image,
            'description' => $client->description,
            'link' => $client->button_link,
            'is_active' => $client->is_active
        ];

        $data = [
            'status' => 200,
            'message' => "Client updated successfully",
            'title' => $client->title->name,
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function honorableClientDetails()
    {
        $clients = HonorableClient::where('is_active', true)
            ->select(['title_id', 'image', 'description', 'link', 'is_active'])
            ->get();

        $formattedclients = [];

        foreach ($clients as $client) {
            $formattedclients[] = [
                'title_id' => $client->title_id,
                'image' => $client->image,
                'description' => $client->description,
                'link' => $client->link,
                'is_active' => $client->is_active

            ];
        }

        $firstclientTitle = $clients->first()->title->name;

        $data = [
            'status' => true,
            'message' => 'Here are your client list:',
            'title' => $firstclientTitle,
            'data' => $formattedclients
        ];

        return response()->json($data, 200);
    }

    public function clientInfo()
    {
        $clients = HonorableClient::select(['title_id', 'image', 'description', 'link', 'is_active'])
            ->get();

        $formattedclients = [];

        foreach ($clients as $client) {
            $formattedclients[] = [
                'title_id' => $client->title_id,
                'image' => $client->image,
                'description' => $client->description,
                'link' => $client->link,
                'is_active' => $client->is_active

            ];
        }

        $firstclientTitle = $clients->first()->title->name;

        $data = [
            'status' => true,
            'message' => 'Here are your client list:',
            'title' => $firstclientTitle,
            'data' => $formattedclients
        ];

        return response()->json($data, 200);
    }

    //Our teams
    public function createOurTeam(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_id' => 'required',
            'name' => 'required',
            'image' => 'required',
            'department' => 'required',
            'designation' => 'required',
            'sequence' => 'required',
        ]);

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

        $team = new OurTeam();
        if ($panelimage = $request->file('image')) {
            $imageName1 = time() . '-' . uniqid() . '.' . $panelimage->getClientOriginalExtension();
            $panelimage->move(public_path('Our team'), $imageName1);
        }

        $team->title_id = $request->title_id;
        $team->name = $request->name;
        $team->image = $imageName1;
        $team->department = $request->department;
        $team->designation = $request->designation;
        $team->sequence = $request->sequence;

        $team->save();

        if ($team->save()) {
            $data = [
                'status' => true,
                'message' => 'Teams successfully created',
                'data' => $team,
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
        $teams = OurTeam::find($id);
        if (!$teams) {
            return response()->json([
                'status' => false,
                'message' => 'Team member id not found',
            ], 404);
        }

        if ($image1 = $request->file('image')) {
            if ($teams->image && file_exists(public_path('Our team') . '/' . $teams->image)) {
                unlink(public_path('Our team') . '/' . $teams->image);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('Our team'), $imageName1);

            $teams->update([
                'image' => $imageName1,
            ]);
        }
        $teams->update([
            'title_id' => $request->title_id,
            'name' => $request->name,
            'department' => $request->department,
            'designation' => $request->designation,
            'sequence' => $request->sequence,
            'is_active' => $request->is_active
        ]);

        $all_data = [
            'image' => $teams->image,
            'name' => $teams->name,
            'department' => $teams->department,
            'designation' => $teams->designation,
            'sequence' => $teams->sequence,
            'is_active' => $teams->is_active
        ];

        $data = [
            'status' => 200,
            'message' => "Team member updated successfully",
            'title' => $teams->title->name,
            'data' => $all_data,
        ];

        return response()->json($data);
    }

    public function ourTeamMemberList()
    {
        $teams = OurTeam::where('is_active', true)
            ->select(['title_id', 'name', 'image', 'department', 'designation', 'sequence', 'is_active'])
            ->orderBy('sequence', 'ASC')
            ->get();

        $formattedteams = [];

        foreach ($teams as $team) {
            $formattedteams[] = [
                'title_id' => $team->title_id,
                'name' => $team->name,
                'image' => $team->image,
                'department' => $team->department,
                'designation' => $team->designation,
                'sequence' => $team->sequence,
                'is_active' => $team->is_active

            ];
        }

        $firstteamTitle = $teams->first()->title->name;

        $data = [
            'status' => true,
            'message' => 'Here are our team member list:',
            'title' => $firstteamTitle,
            'data' => $formattedteams
        ];

        return response()->json($data, 200);
    }

    public function teammemberInfo()
    {
        $teams = OurTeam::select(['title_id', 'name', 'image', 'department', 'designation', 'sequence', 'is_active'])
            ->orderBy('sequence', 'ASC')
            ->get();

        $formattedteams = [];

        foreach ($teams as $team) {
            $formattedteams[] = [
                'title_id' => $team->title_id,
                'name' => $team->name,
                'image' => $team->image,
                'department' => $team->department,
                'designation' => $team->designation,
                'sequence' => $team->sequence,
                'is_active' => $team->is_active

            ];
        }

        $firstteamTitle = $teams->first()->title->name;

        $data = [
            'status' => true,
            'message' => 'Here are our team member list:',
            'title' => $firstteamTitle,
            'data' => $formattedteams
        ];

        return response()->json($data, 200);
    }

    //Case Studies
    public function createCaseStudies(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_id' => 'required',
            'title_name' => 'required',
            'description' => 'required'
        ]);

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

        $case = new CaseStudy();


        $case->title_id = $request->title_id;
        $case->title_name = $request->title_name;
        $case->description = $request->description;
        $case->save();

        if ($case->save()) {
            $data = [
                'status' => true,
                'message' => 'Case studies successfully created',
                'data' => $case,
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
        $case = CaseStudy::find($id);
        if (!$case) {
            return response()->json([
                'status' => false,
                'message' => 'Case is not found',
            ], 404);
        }
        $case->update([
            'title_id' => $request->title_id,
            'title' => $request->title,
            'description' => $request->description,
            'is_active' => $request->is_active
        ]);

        $all_data = [
            'title' => $case->title,
            'description' => $case->description,
            'is_active' => $case->is_active
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
        $cases = CaseStudy::where('is_active', true)
            ->select(['title_id', 'title_name', 'description', 'is_active'])
            ->get();

        $formattedcase = [];

        foreach ($cases as $case) {
            $formattedcase[] = [
                'title_id' => $case->title_id,
                'title_name' => $case->title_name,
                'description' => $case->description,
                'is_active' => $case->is_active

            ];
        }

        $title_id = $cases->first()->title->name;

        $data = [
            'status' => true,
            'message' => 'Here are our case study list:',
            'title' => $title_id,
            'data' => $formattedcase
        ];

        return response()->json($data, 200);
    }

    public function caseStudyInfo()
    {
        $cases = CaseStudy::select(['title_id', 'title_name', 'description', 'is_active'])
            ->get();

        $formattedcase = [];

        foreach ($cases as $case) {
            $formattedcase[] = [
                'title_id' => $case->title_id,
                'title_name' => $case->title_name,
                'description' => $case->description,
                'is_active' => $case->is_active

            ];
        }

        $title_id = $cases->first()->title->name;

        $data = [
            'status' => true,
            'message' => 'Here are our case study list:',
            'title' => $title_id,
            'data' => $formattedcase
        ];

        return response()->json($data, 200);
    }

    //Testimonial
    public function createTestimonial(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_id' => 'required',
            'subtitle_id' => 'required',
            'image' => 'required',
            'name' => 'required',
            'designation' => 'required',
            'review' => 'required',
            'feed_back' => 'required'
        ]);

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
        $testimonial = new Testimonial();
        if ($panelimage = $request->file('image')) {
            $imageName1 = time() . '-' . uniqid() . '.' . $panelimage->getClientOriginalExtension();
            $panelimage->move(public_path('Testimonial'), $imageName1);
        }

        $testimonial->title_id = $request->title_id;
        $testimonial->subtitle_id = $request->subtitle_id;
        $testimonial->name = $request->name;
        $testimonial->image = $imageName1;
        $testimonial->designation = $request->designation;
        $testimonial->review = $request->review;
        $testimonial->feed_back = $request->feed_back;
        $testimonial->save();

        if ($testimonial->save()) {
            $data = [
                'status' => true,
                'message' => 'Testimonial successfully created',
                'data' => $testimonial,
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
        $testimonial = Testimonial::find($id);
        if (!$testimonial) {
            return response()->json([
                'status' => false,
                'message' => 'Testimonial id not found',
            ], 404);
        }

        if ($image1 = $request->file('image')) {
            if ($testimonial->image && file_exists(public_path('Testimonial') . '/' . $testimonial->image)) {
                unlink(public_path('Testimonial') . '/' . $testimonial->image);
            }

            $imageName1 = time() . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $image1->move(public_path('Testimonial'), $imageName1);

            $testimonial->update([
                'image' => $imageName1,
            ]);
        }
        $testimonial->update([
            'title_id' => $request->title_id,
            'sub_title_id' => $request->sub_title_id,
            'name' => $request->name,
            'designation' => $request->designation,
            'review' => $request->review,
            'feed_back' => $request->feed_back,
            'is_active' => $request->is_active
        ]);

        $all_data = [
            'title' => $testimonial->title->name,
            'sub_title' => $testimonial->subtitle->name,
            'name' => $testimonial->name,
            'review' => $testimonial->review,
            'is_active' => $testimonial->is_active
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
        $testiminoials = Testimonial::where('is_active', true)
            ->select(['title_id', 'subtitle_id', 'name', 'image', 'review', 'feed_back', 'is_active'])
            ->get();

        $formattedtestimonial = [];

        foreach ($testiminoials as $testimonial) {
            $formattedtestimonial[] = [
                'title_id' => $testimonial->title_id,
                'subtitle_id' => $testimonial->subtitle_id,
                'name' => $testimonial->name,
                'image' => $testimonial->image,
                'review' => $testimonial->review,
                'feed_back' => $testimonial->feed_back,
                'is_active' => $testimonial->is_active
            ];
        }

        $title_id = $testiminoials->first()->title->name;
        $subtitle = $testiminoials->first()->subtitle->name;
        $data = [
            'status' => true,
            'message' => 'Here are our team member list:',
            'title' => $title_id,
            'sub_tilte' => $subtitle,
            'data' => $formattedtestimonial
        ];

        return response()->json($data, 200);
    }

    public function testimonialInfo()
    {
        $testimonials = Testimonial::select(['title_id', 'subtitle_id', 'name', 'image', 'review', 'feed_back', 'is_active'])
            ->get();

        $formattedtestimonial = [];

        foreach ($testimonials as $testimonial) {
            $formattedtestimonial[] = [
                'title_id' => $testimonial->title_id,
                'subtitle_id' => $testimonial->subtitle_id,
                'name' => $testimonial->name,
                'image' => $testimonial->image,
                'review' => $testimonial->review,
                'feed_back' => $testimonial->feed_back,
                'is_active' => $testimonial->is_active
            ];
        }

        $title_id = $testimonials->first()->title->name;
        $subtitle = $testimonials->first()->subtitle->name;
        $data = [
            'status' => true,
            'message' => 'Here are our team member list:',
            'title' => $title_id,
            'sub_tilte' => $subtitle,
            'data' => $formattedtestimonial
        ];

        return response()->json($data, 200);
    }
}
