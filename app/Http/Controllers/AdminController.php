<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function AdminDashboard()
    {
        return view('admin.index');
    } // End Method

    public function AdminLogin()
    {
        return view('admin.admin_login');
    } // End Method

    public function AdminDestroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    } // End Method

    public function AdminProfile()
    {
        $id = Auth::user()->id;
        $adminData = User::find($id);

        return view('admin.admin_profile_view', compact('adminData'));
    } //End Method

    public function AdminProfileStore(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/admin_images/' . $data->photo));
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'), $filename);
            $data['photo'] = $filename;
        }

        $data->save();

        $notification = [
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } // End Method

    public function AdminChangePassword()
    {
        return view('admin.admin_change_password');
    } // End Method

    public function AdminUpdatePassword(Request $request)
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

    public function InactiveVendor()
    {
        $inactiveVendor = User::where('status', 'inactive')->where('role', 'vendor')->latest()->get();
        return view('backend.vendor.inactive_vendor', compact('inactiveVendor'));
    } // End Method

    public function ActiveVendor()
    {
        $activeVendor = User::where('status', 'active')->where('role', 'vendor')->latest()->get();
        return view('backend.vendor.active_vendor', compact('activeVendor'));
    } // End Method

    public function InactiveVendorDetails($id)
    {
        $inactiveVendorDetails = User::findOrFail($id);
        return view('backend.vendor.inactive_vendor_details', compact('inactiveVendorDetails'));
    } // End Method

    public function ActiveVendorApprove(Request $request)
    {
        $vendor_id = $request->id;
        User::findOrFail($vendor_id)->update([
            'status' => 'active',
        ]);

        $notification = [
            'message' => 'Vendor Activated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('active.vendor')->with($notification);
    } // End Method

    public function ActiveVendorDetails($id)
    {
        $activeVendorDetails = User::findOrFail($id);
        return view('backend.vendor.active_vendor_details', compact('activeVendorDetails'));
    } // End Method

    public function ActiveVendorDisapprove(Request $request)
    {

        $vendor_id = $request->id;
        User::findOrFail($vendor_id)->update([
            'status' => 'inactive',
        ]);

        $notification = [
            'message' => 'Vendor De-activated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('inactive.vendor')->with($notification);
    } // End Method
}
