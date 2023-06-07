<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class VendorController extends Controller
{
    public function VendorDashboard()
    {
        return view('vendor.index');
    } // End Method

    public function VendorLogin()
    {
        return view('vendor.vendor_login');
    } // End Method

    public function VendorDestroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/vendor/login');
    } // End Method

    public function VendorProfile()
    {
        $id = Auth::user()->id;
        $vendorData = User::find($id);

        return view('vendor.vendor_profile_view', compact('vendorData'));
    } //End Method

    public function VendorProfileStore(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->vendor_join = $request->vendor_join;
        $data->vendor_short_info = $request->vendor_short_info;


        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/vendor_images/' . $data->photo));
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/vendor_images'), $filename);
            $data['photo'] = $filename;
        }

        $data->save();

        $notification = [
            'message' => 'Vendor Profile Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } // End Method

    public function VendorChangePassword()
    {
        return view('vendor.vendor_change_password');
    } // End Method

    public function VendorUpdatePassword(Request $request)
    {

        //Validate
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        //Match Old Password
        if (!Hash::check($request->old_password, Auth::user()->password)) {
            return back()->with("error", "Old Password Don't Match!!");
        }

        //Update New Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);
        return back()->with('status', 'Password Updated');
    } // End Method

    public function BecomeVendor()
    {
        return view('auth.become_vendor');
    } //End Method

    public function VendorRegister(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::insert([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'vendor_join' => $request->vendor_join,
            'password' => Hash::make($request->password),
            'role' => 'vendor',
            'status' => 'inactive',

        ]);

        $notification = [
            'message' => 'Vendor Registered Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('vendor.login')->with($notification);
    } //End Method


}
