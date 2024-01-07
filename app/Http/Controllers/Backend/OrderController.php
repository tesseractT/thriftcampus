<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
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
    } //End Method

    public function AdminProcessingOrder()
    {
        $orders = Order::where('status', 'processing')->orderBy('id', 'desc')->get();
        return view('backend.orders.processing_orders', compact('orders'));
    } //End Method

    public function AdminDeliveredOrder()
    {
        $orders = Order::where('status', 'delivered')->orderBy('id', 'desc')->get();
        return view('backend.orders.delivered_orders', compact('orders'));
    } //End Method

    public function PendingToConfirm($order_id)
    {
        Order::findOrFail($order_id)->update(['status' => 'confirmed']);

        $notification = [
            'message' => 'Order Confirmed Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('admin.confirmed.order')->with($notification);
    } //End Method

    public function ConfirmedToProcessing($order_id)
    {
        Order::findOrFail($order_id)->update(['status' => 'processing']);

        $notification = [
            'message' => 'Order Processing Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('admin.processing.order')->with($notification);
    } //End Method

    public function ProcessingToDelivered($order_id)
    {
        Order::findOrFail($order_id)->update(['status' => 'delivered']);

        $notification = [
            'message' => 'Order Delivered Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('admin.delivered.order')->with($notification);
    } //End Method
    public function AdminInvoiceDownload($order_id)
    {
        $order = Order::with('division', 'district', 'state', 'user')->where('id', $order_id)->first();
        $orderItem = OrderItem::with('product')->where('order_id', $order_id)->orderBy('id', 'DESC')->get();

        $pdf = Pdf::loadView('backend.orders.admin_order_invoice', compact('order', 'orderItem'))->setPaper('a4')->setOption([
            'tempDir' => public_path(),
            'chroot' => public_path(),
        ]);
        return $pdf->download($order->name . '_' . $order->invoice_no);
    } //End Method
}
