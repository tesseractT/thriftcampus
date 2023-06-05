<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManagerStatic as Image;

class BrandController extends Controller
{
    public function AllBrand()
    {
        $brands = Brand::latest()->get();
        return view('backend.brand.brand_all', compact('brands'));
    }
    //End Method

    public function AddBrand()
    {
        $brands = Brand::latest()->get();
        return view('backend.brand.brand_add', compact('brands'));
    }
    //end Method

    public function StoreBrand(Request $request)
    {
        $image = $request->file('brand_image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(300, 300)->save('upload/brand/' . $name_gen);

        $save_url = 'upload/brand/' . $name_gen;

        Brand::insert([
            'brand_name' => $request->brand_name,
            'brand_slug' => strtolower(str_replace(' ', '-', $request->brand_name)),
            'brand_image' => $save_url,
            'created_at' => Carbon::now()

        ]);

        $notification = [
            'message' => 'Brand Added Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.brand')->with($notification);
    } //end Method

    public function EditBrand($id)
    {
        $brand = Brand::findOrFail($id);
        return view('backend.brand.brand_edit', compact('brand'));
    } //end Method

    public function UpdateBrand(Request $request)
    {
        $brand_id = $request->id;
        $old_img = $request->old_image;

        if ($request->file('brand_image')) {
            $image = $request->file('brand_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save('upload/brand/' . $name_gen);

            $save_url = 'upload/brand/' . $name_gen;

            if (file_exists($old_img)) {
                unlink($old_img);
            }

            Brand::findOrFail($brand_id)->update([
                'brand_name' => $request->brand_name,
                'brand_slug' => strtolower(str_replace(' ', '-', $request->brand_name)),
                'brand_image' => $save_url,
                'updated_at' => Carbon::now()

            ]);

            $notification = [
                'message' => 'Brand Updated With Image Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->route('all.brand')->with($notification);
        } else {
            Brand::findOrFail($brand_id)->update([
                'brand_name' => $request->brand_name,
                'brand_slug' => strtolower(str_replace(' ', '-', $request->brand_name)),
                'updated_at' => Carbon::now()

            ]);

            $notification = [
                'message' => 'Brand Updated Without Image Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->route('all.brand')->with($notification);
        }
    } //End Method

    public function DeleteBrand($id)
    {
        $brand = Brand::findOrFail($id);
        $img =  $brand->brand_image;
        unlink($img);

        Brand::findOrFail($id)->delete();

        $notification = [
            'message' => 'Brand Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } //End Method
}
