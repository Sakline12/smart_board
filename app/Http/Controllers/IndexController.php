<?php

namespace App\Http\Controllers;

use App\Models\IndexSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{
    public function create_index_slider(Request $request)
    {
        $rules = array(
            'image' => 'required',
            'title' => 'required',
            'content' =>  'required',
            'button_text' => 'required',
            'isActive' => 'required'
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
            $image->move(public_path('profile'), $imageName);
        }

        $index->title = $request->title;
        $index->content = $request->content;
        $index->button_text = $request->button_text;
        $index->isActive = $request->isActive;
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
        $index = IndexSlider::where('isActive',true)->get();
        $data = [
            'status' => true,
            'message' => 'Here are your index items',
            'data' => $index
        ];
        return response()->json($data, 200);
    }

    public function delete_index_slider(Request $request,$id){
       $index=IndexSlider::where('id',$id)->delete();
       if($index){
        $data=[
            'status'=>true,
            'message'=>'Delete this items successfully',
            'data'=>$index
        ];
        return response()->json($data);
       }
       else{
        $data=[
            'status'=>false,
            'message'=>'Error has has been occured',
            'data'=>$index
        ];
        return response()->json($data,500);
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

    public function slider_item_list(){
        $index=IndexSlider::all();
        
        $data=[
           'status'=>true,
           'message'=>"Here are all index slider:",
           'data'=>$index
        ];
        return response()->json($data);
    }
    
    
}
