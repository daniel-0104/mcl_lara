<?php

namespace App\Http\Controllers;

use Log;
use App\Models\cart;
use App\Models\order;
use App\Models\orderList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ajaxController extends Controller
{
    //add to cart
    public function addToCart(Request $request){
        $data = $this->getOrderData($request);
        cart::create($data);
        $response = [
            'message' => 'Add To Cart Complete',
            'status' => 'Success'
        ];
        return response()->json($response, 200);
    }

    //cart remove
    public function cartRemove(Request $request){
        cart::where('id', $request->cartId)->delete();
        return back();
    }

    //cart checkout
    public function cartCheckOut(Request $request){
        $orderList = $request->query('orderList');
        $finalPrice = $request->query('finalPrice');

        foreach ($orderList as $item) {
            orderList::create([
                'user_name' => Auth::user()->name,
                'plan' => $item['plan'],
                'price' => preg_replace('/[^0-9]/', '', $item['price']),
                'cash_back' => $item['cash_back'],
                'duration' => $item['duration'],
                'order_code' => $item['order_code']
            ]);
        }

        cart::where('user_name', Auth::user()->name)->delete();

        order::create([
            'user_name' => Auth::user()->name,
            'order_code' => $orderList[0]['order_code'],
            'qty' => count($orderList),
            'total_price' => $finalPrice
        ]);

        return response()->json([
            'status' => 'true',
            'message' => 'order completed'
        ],200);
    }


    //get order data
    private function getOrderData($request){
        return[
            'user_name' => $request->userName,
            'plan' => $request->userPlan,
            'price' => $request->userPrice,
            'cash_back' => $request->userCash,
            'duration' => $request->userTime
        ];
    }
}
