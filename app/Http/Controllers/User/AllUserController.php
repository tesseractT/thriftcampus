<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AllUserController extends Controller
{
    public function UserAccount()
    {
        $id = Auth::user()->id;
        $userData = User::find($id);
        return view('frontend.userdashboard.account_details', compact('userData'));
    } // End Method


    public function UserChangePassword()
    {
        return view('frontend.userdashboard.user_change_password');
    } // End Method


    public function UserOrderPage()
    {
        $id = Auth::user()->id;
        $orders = Order::where('user_id', $id)->orderBy('id', 'DESC')->get();

        return view('frontend.userdashboard.user_order_page', compact('orders'));
    } // End Method

    public function UserOrderDetails($order_id)
    {
        $order = Order::with('division', 'district', 'state', 'user')->where('id', $order_id)->where('user_id', Auth::id())->first();
        $orderItem = OrderItem::with('product')->where('order_id', $order_id)->orderBy('id', 'DESC')->get();

        return view('frontend.order.order_details', compact('order', 'orderItem'));
    } // End Method

    public function UserOrderInvoice($order_id)
    {
        $order = Order::with('division', 'district', 'state', 'user')->where('id', $order_id)->where('user_id', Auth::id())->first();
        $orderItem = OrderItem::with('product')->where('order_id', $order_id)->orderBy('id', 'DESC')->get();

        $pdf = Pdf::loadView('frontend.order.order_invoice', compact('order', 'orderItem'))->setPaper('a4')->setOption([
            'tempDir' => public_path(),
            'chroot' => public_path(),
        ]);
        return $pdf->download($order->name . '_' . $order->invoice_no);

        //return view('frontend.order.order_invoice', compact('order', 'orderItem'));
    } //End Method

    public function ReturnOrder(Request $request, $order_id)
    {
        Order::findOrFail($order_id)->update([
            'return_order' => 1,
            'return_reason' => $request->return_reason,
            'return_date' => Carbon::now()->format('d F Y'),
        ]);
        $notification = [
            'message' => 'Return Request Sent',
            'alert-type' => 'success',
        ];

        return redirect()->route('user.order.page')->with($notification);
    } //End Method

    public function ReturnOrderPage()
    {
        $id = Auth::user()->id;
        $orders = Order::where('user_id', $id)->where('return_reason', '!=', NULL)->orderBy('id', 'DESC')->get();

        return view('frontend.order.return_order_view', compact('orders'));
    } // End Method

    public function UserTrackOrder()
    {
        return view('frontend.userdashboard.user_track_order');
    } // End Method

    public function OrderTracking(Request $request)
    {

        $invoice = $request->code;

        $track = Order::where('invoice_no', $invoice)->first();

        if ($track) {
            return view('frontend.tracking.track_order', compact('track'));
        } else {

            $notification = array(
                'message' => 'Invoice Code Is Invalid',
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }
    } // End Method
}
