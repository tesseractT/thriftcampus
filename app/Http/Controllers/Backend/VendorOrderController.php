<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;

class VendorOrderController extends Controller
{
    public function VendorOrder()
    {   $id = Auth::user()->id;
        $orderItem = OrderItem::with('order')->where('vendor_id', $id)->orderBy('id', 'desc')->get();
        return view('vendor.backend.orders.pending_orders', compact('orderItem'));
    }
    //End Method
}
