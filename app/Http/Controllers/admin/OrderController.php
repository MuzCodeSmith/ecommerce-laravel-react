<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('created_at', 'DESC')->with('items')->get();

        return response()->json([
            "status" => 200,
            "data" => $orders
        ], 200);
    }
    public function detail($id)
    {
        $order = Order::with('items','items.product')->find($id);

        if (!$order) {
            return response()->json([
                "status" => 404,
                "message" => "Order not found!",
                "data" => []
            ], 404);
        }

        return response()->json([
            "status" => 200,
            "data" => $order
        ], 200);
    }
}
