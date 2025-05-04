<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(){
        $products = Product::orderBy('created_at','DESC')->get();
        return response()->json([
            "status"=>200,
            "message"=>"products fetched successfully",
            "data"=>$products
        ],200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'title'=>'required',
            'price'=>'required|numeric',
            'category'=>'required|integer',
            'sku'=>'required|unique:products,sku',
            'is_featured'=>'required',
            'status'=>'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'message'=>$validator->errors()
            ],400);
        }

        $product = new Product();
        $product->title = $request->title; 
        $product->price = $request->price; 
        $product->compare_price = $request->compare_price; 
        $product->category_id = $request->category; 
        $product->brand_id = $request->brand; 
        $product->sku = $request->sku; 
        $product->qty = $request->qty; 
        $product->description = $request->description; 
        $product->short_description = $request->short_description; 
        $product->status = $request->status; 
        $product->barcode = $request->barcode; 
        $product->is_featured = $request->is_featured; 
        $product->save();

        return response()->json([
            'status'=>200,
            'message'=>'Product has been created successfully'
        ],200);
    }

    public function show($id){
        $product = Product::find($id);

        if(!$product){
            return response()->json([
                'status'=>404,
                'message'=>'Product not found!'
            ],404);
        }

        return response()->json([
                'status'=>200,
                'data'=>$product
            ],200);
        
    }

    public function update($id, Request $request){

        $product = Product::find($id);

        if(!$product){
            return response()->json([
                'status'=>404,
                'message'=>'Product not found!'
            ],404);
        }

        $validator = Validator::make($request->all(),[
            'title'=>'required',
            'price'=>'required|numeric',
            'category'=>'required|integer',
            'sku'=>'required|unique:products,sku,'.$id.',id',
            'is_featured'=>'required',
            'status'=>'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'message'=>$validator->errors()
            ],400);
        }

        $product->title = $request->title; 
        $product->price = $request->price; 
        $product->compare_price = $request->compare_price; 
        $product->category_id = $request->category; 
        $product->brand_id = $request->brand; 
        $product->sku = $request->sku; 
        $product->qty = $request->qty; 
        $product->description = $request->description; 
        $product->short_description = $request->short_description; 
        $product->status = $request->status; 
        $product->barcode = $request->barcode; 
        $product->is_featured = $request->is_featured; 
        $product->save();

        return response()->json([
            'status'=>200,
            'message'=>'Product has been updated successfully'
        ],200);
    }

    public function destroy(){
        
    }

}
