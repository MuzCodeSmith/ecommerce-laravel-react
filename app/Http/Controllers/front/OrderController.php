<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use User;

class OrderController extends Controller
{
    public function saveOrder(Request $request){

        if(!empty($request->cart)){

            $order = new Order();
            $order->name = $request->name;
            $order->email = $request->email;
            $order->address = $request->address;
            $order->mobile = $request->mobile;
            $order->state = $request->state;
            $order->zip = $request->zip;
            $order->city = $request->city;
            $order->grand_total = $request->grand_total;
            $order->subtotal = $request->sub_total;
            $order->discount = $request->discount;
            $order->shipping = $request->shipping;
            $order->payment_status = $request->payment_status;
            $order->status = $request->status;
            $order->user_id = $request->user()->id;
            $order->save();
    
            // save order items
            foreach($request->cart as $item){
                $orderItem = new OrderItem();
                $orderItem->price = $item['qty'] * $item['price'] ;
                $orderItem->order_id = $order->id;
                $orderItem->name = $item['title'];
                $orderItem->unit_price =$item['price'] ;
                $orderItem->qty =$item['qty'];
                $orderItem->product_id =$item['product_id'];
                $orderItem->size =$item['size'];
                $orderItem->save();
            }
    
            return response()->json([
                "status" => 200,
                'id'=>$order->id,
                "message" => "Order placed Successfully",
            ],200);
        }else{
            return response()->json([
                "status" => 400,
                "message" => "Your cart is Empty",
            ],400);
        }

    }
}
