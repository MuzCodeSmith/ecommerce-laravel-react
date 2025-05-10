<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use PDO;

class ProductController extends Controller
{
    public function latestProducts(){
        $latestProducts = Product::orderBy('created_at','DESC')
        ->where('status',1)
        ->limit(8)
        ->get();
        return response()->json([
            "status"=>200,
            "data"=>$latestProducts,
        ],200);
    }

    public function featuredProducts(){
        $featuredProducts = Product::orderBy('created_at','DESC')
                            ->where('status',1)
                            ->where('is_featured','yes')
                            ->limit(8)
                            ->get();
        return response()->json([
            "status"=>200,
            "data"=>$featuredProducts,
        ],200);
    }
    public function getCategories(){
        $categories = Category::orderBy('name','ASC')
                            ->where('status',1)
                            ->get();
        return response()->json([
            "status"=>200,
            "data"=>$categories,
        ],200);
    }
    public function getBrands(){
        $brands = Brand::orderBy('name','ASC')
                            ->where('status',1)
                            ->get();
        return response()->json([
            "status"=>200,
            "data"=>$brands,
        ],200);
    }

    public function getProducts(Request $request){
        $products = Product::orderby('created_at','DESC')->where('status',1);

        if(!empty($request->category)){
            $catArr = explode(',',$request->category);
            $products= $products->whereIn('category_id',$catArr);
        }

        if(!empty($request->brand)){
            $brandArr = explode(',',$request->brand);
            $products = $products->whereIn('brand_id',$brandArr);
        }

        $products=$products->get();


        return response()->json([
            "status"=>200,
            "data"=>$products,
        ],200);
    }

    public function getProduct($id){
        $product = Product::with('product_images','product_sizes.size')->find($id);

        if(!$product){
            return response()->json([
                "status"=>400,
                "message"=>"product not found",
            ],400);
        }

        return response()->json([
            "status"=>200,
            "data"=>$product,
        ],200);
    }
    
}
