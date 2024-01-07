<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;

class OrderController extends Controller
{
    public function PendingOrder()
    {
        $orders = Order::where('status', 'pending')->orderBy('id', 'desc')->get();
        return view('backend.orders.pending_orders', compact('orders'));
    }
    //End Method

    public function AdminOrderDetails($order_id)
    {

        $order = Order::with('division', 'district', 'state', 'user')->where('id', $order_id)->first();
        $orderItem = OrderItem::with('product')->where('order_id', $order_id)->orderBy('id', 'DESC')->get();

        return view('backend.orders.admin_order_details', compact('order', 'orderItem'));
    } // End Method

    public function AdminConfirmedOrder()
    {
        $orders = Order::where('status', 'confirmed')->orderBy('id', 'desc')->get();
        return view('backend.orders.confirmed_orders', compact('orders'));
    }//End Method

    public function AdminProcessingOrder(){
        $orders = Order::where('status', 'processing')->orderBy('id', 'desc')->get();
        return view('backend.orders.processing_orders', compact('orders'));

    }//End Method

    public function AdminDeliveredOrder(){
        $orders = Order::where('status', 'delivered')->orderBy('id', 'desc')->get();
        return view('backend.orders.delivered_orders', compact('orders'));

    }
}
