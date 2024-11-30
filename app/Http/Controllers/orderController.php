<?php

namespace App\Http\Controllers;

use Log;
use Carbon\Carbon;
use App\Models\order;
use App\Models\message;
use App\Models\orderList;
use Illuminate\Http\Request;
use App\Mail\StatusExpiredMail;
use App\Mail\StatusAcceptedMail;
use App\Mail\StatusRejectedMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class orderController extends Controller
{
    //order list
    public function orderList(){
        $orderCounts = order::where('status','0')->get();
        $orders = order::select('orders.*')
                        ->when(request('key'),function($query){
                            $query->orWhere('orders.user_name','like','%'.request('key').'%')
                                    ->orWhere('orders.order_code','like','%'.request('key').'%');
                        })
                        ->when(request('status') !== null, function ($query) {
                            $query->where('orders.status', (int) request('status'));
                        })
                        ->orderBy('id','desc')
                        ->paginate(30);
        return view('main.admin.orders.list',compact('orderCounts','orders'));
    }

    //order view
    public function orderView($orderCode){
        $orderCounts = order::where('status','0')->get();
        $orders = order::where('order_code',$orderCode)->first();
        $orderLists = orderList::where('order_code',$orderCode)->get();
        return view('main.admin.orders.view',compact('orderCounts','orders','orderLists'));
    }

    //order status change
    public function orderStatus(Request $request){
        $order = order::select('orders.*', 'users.email as user_email', 'order_lists.duration as order_duration')
                    ->leftJoin('users', 'users.name', '=', 'orders.user_name')
                    ->leftJoin('order_lists', 'order_lists.order_code', '=', 'orders.order_code')
                    ->where('orders.id', $request->orderId)
                    ->first();

        if ($order->status != $request->status) {
            $order->status = $request->status;
            $order->save();

            if ($request->status == 1) {
                if ($request->has('start_date')) {
                    $order->start_date = Carbon::parse($request->start_date)->setTimezone('Asia/Yangon');
                } else {
                    $order->start_date = $order->updated_at;
                }

                Log::info('Start Date: ' . $order->start_date);

                switch ($order->order_duration) {
                    case 'Monthly':
                        $order->end_date = Carbon::parse($order->start_date)->addMonths($order->qty)->setTimezone('Asia/Yangon')->toDateTimeString();
                        break;
                    case 'Yearly':
                        $order->end_date = Carbon::parse($order->start_date)->addYears($order->qty)->setTimezone('Asia/Yangon')->toDateTimeString();
                        break;
                    case 'Ownership Transfer':
                        $order->end_date = 'sold';
                        break;
                    default:
                        $order->end_date = Carbon::parse($order->start_date)->addHours(24)->setTimezone('Asia/Yangon')->toDateTimeString();
                        break;
                }

                Log::info('End Date (after adding 24 hours): ' . $order->end_date);

                $order->save();
                Mail::to($order->user_email)->send(new StatusAcceptedMail($order));
                return response()->json(['success' => 'Order status updated and email sent successfully']);

            }
            elseif ($request->status == 2) {
                Mail::to($order->user_email)->send(new StatusRejectedMail($order));
                return response()->json(['success' => 'Order status updated and email sent successfully']);
            }
            elseif ($request->status == 3) {
                Mail::to($order->user_email)->send(new StatusExpiredMail($order));
                return response()->json(['success' => 'Order status updated and email sent successfully']);
            }

            return response()->json(['success' => 'Order status updated successfully']);
        }

        return response()->json(['success' => 'No changes were made to the order status']);
    }


    //order delete
    public function orderDelete($orderCode){
        order::where('order_code',$orderCode)->delete();
        orderList::where('order_code',$orderCode)->delete();
        return back()->with(['deleteSuccess'=>'The order was deleted successfully...']);
    }
}
