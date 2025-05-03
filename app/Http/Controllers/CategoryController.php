<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    // this method will return all categories
    public function index(){
        $categories = Category::orderBy('created_at','DESC')->get();
        return response()->json([
            'status'=>200,
            'data'=>$categories
        ]);
    }

    // this method will store category in DB
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=> 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'data'=>$validator->errors()
            ],400); 
        }

        $category = new Category();
        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();

        return response()->json([
            'status'=>200,
            'message'=>'category added successfully',
            'data'=>$category
        ],200);

    }
    
    // this method will return a single category
    public function show($id){
        $category = Category::find($id);

        if(!$category){
            return response()->json([
                'status'=>404,
                'message'=>'category not found',
            ]);
        }

        if($category){
            return response()->json([
                'status'=>200,
                'message'=>'category fetched successfully',
                'data'=>$category
            ]);
        }
    }

    // this method will update a single category
    public function update($id,Request $request){


        $category = Category::find($id);

        if(!$category){
            return response()->json([
                'status'=>401,
                'message'=>'category not found',
                'data'=>[]
            ],401);
        }

        
        $validator = Validator::make($request->all(),[
            'name'=>'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->errors()
            ],400); 
        }

        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();

        return response()->json([
            'status'=>200,
            'message'=>'category updated successfully',
            'data'=>$category
        ]);
    }

    // this method will delete a single category
    public function delete(){

    }
}
