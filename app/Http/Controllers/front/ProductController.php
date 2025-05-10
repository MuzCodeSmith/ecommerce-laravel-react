<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
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

    
}
