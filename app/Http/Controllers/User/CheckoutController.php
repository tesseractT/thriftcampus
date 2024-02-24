<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\ShipDivision;
use App\Models\ShipDistricts;
use App\Models\ShipState;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Auth;



class CheckoutController extends Controller
{
    public function DistrictGetAjax($division_id)
    {
        try {
            $ship = ShipDistricts::where('division_id', $division_id)->orderBy('district_name', 'ASC')->get();
            return json_encode($ship);
        } catch (\Exception $e) {
            Log::error("Error executing query: " . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch district data.'], 500);
        }
    } // End Method

    public function StateGetAjax($district_id)
    {
        try {
            $ship = ShipState::where('district_id', $district_id)->orderBy('state_name', 'ASC')->get();
            return json_encode($ship);
        } catch (\Exception $e) {
            Log::error("Error executing query: " . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch district data.'], 500);
        }
    } // End Method
    public function CheckoutStore(Request $request)
    {
        $data = [];
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_email'] = $request->shipping_email;
        $data['division_id'] = $request->division_id;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['district_id'] = $request->district_id;
        $data['shipping_address'] = $request->shipping_address;
        $data['state_id'] = $request->state_id;
        $data['post_code'] = $request->post_code;
        $data['notes'] = $request->notes;

        $cartTotal = Cart::total();

        if ($request->payment_option == 'stripe') {
            return view('frontend.payment.stripe', compact('data', 'cartTotal'));
        } elseif ($request->payment_option == 'card') {
            return 'CARD PAGE';
        } else {
            return view('frontend.payment.cash', compact('data', 'cartTotal'));
        }
    } // End Method

}
