<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\MultiImg;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class ProductController extends Controller
{
    public function AllProduct()
    {
        $products = Product::latest()->get();
        return view('backend.product.product_all', compact('products'));
    } //End Method

    public function AddProduct()
    {
        $activeVendor = User::where('status', 'active')->where('role', 'vendor')->latest()->get();
        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        return view('backend.product.product_add', compact('brands', 'categories', 'activeVendor'));
    } //end Method

    public function StoreProduct(Request $request)
    {
        $image = $request->file('product_thumbnail');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(800, 800)->save('upload/products/thumbnail/' . $name_gen);

        $save_url = 'upload/products/thumbnail/' . $name_gen;

        $product_id = Product::insertGetId([
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'product_name' => $request->product_name,
            'product_slug' => strtolower(str_replace(' ', '-', $request->product_name)),
            'product_code' => $request->product_code,
            'product_qty' => $request->product_qty,
            'product_tags' => $request->product_tags,
            'product_size' => $request->product_size,
            'product_color' => $request->product_color,
            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_desc' => $request->short_desc,
            'long_desc' => $request->long_desc,
            'hot_deals' => $request->hot_deals,
            'featured' => $request->featured,
            'special_offer' => $request->special_offer,
            'special_deals' => $request->special_deals,
            'product_thumbnail' => $save_url,
            'vendor_id' => $request->vendor_id,
            'status' => 1,
            'created_at' => Carbon::now(),

        ]);

        //Multi Image Upload
        $images = $request->file('multi_imgs');
        foreach ($images as $image) {
            $make_name = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(800, 800)->save('upload/products/multi-images/' . $make_name);

            $upload_path = 'upload/products/multi-images/' . $make_name;

            MultiImg::insert([
                'product_id' => $product_id,
                'photo_name' => $upload_path,
                'created_at' => Carbon::now()
            ]);
        } //End Foreach
        $notification = [
            'message' => 'Product Added Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.product')->with($notification);
    } //end Method

    public function EditProduct($id)
    {
        $multiImgs = MultiImg::where('product_id', $id)->get();
        $activeVendor = User::where('status', 'active')->where('role', 'vendor')->latest()->get();
        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        $subcategories = SubCategory::latest()->get();
        $products = Product::findOrFail($id);
        return view('backend.product.product_edit', compact('brands', 'categories', 'activeVendor', 'products', 'subcategories', 'multiImgs'));
    } //End Method

    public function UpdateProduct(Request $request)
    {
        $product_id = $request->id;

        Product::findOrFail($product_id)->update([
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'product_name' => $request->product_name,
            'product_slug' => strtolower(str_replace(' ', '-', $request->product_name)),
            'product_code' => $request->product_code,
            'product_qty' => $request->product_qty,
            'product_tags' => $request->product_tags,
            'product_size' => $request->product_size,
            'product_color' => $request->product_color,
            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_desc' => $request->short_desc,
            'long_desc' => $request->long_desc,
            'hot_deals' => $request->hot_deals,
            'featured' => $request->featured,
            'special_offer' => $request->special_offer,
            'special_deals' => $request->special_deals,
            'vendor_id' => $request->vendor_id,
            'status' => 1,
            'updated_at' => Carbon::now(),

        ]);

        $notification = [
            'message' => 'Product Updated without image Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.product')->with($notification);
    } //End Method

    public function UpdateProductThumbnail(Request $request)
    {
        $pro_id = $request->id;
        $oldImage = $request->old_img;

        $image = $request->file('product_thumbnail');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(800, 800)->save('upload/products/thumbnail/' . $name_gen);

        $save_url = 'upload/products/thumbnail/' . $name_gen;

        if (file_exists($oldImage)) {
            unlink($oldImage);
        }

        Product::findOrFail($pro_id)->update([
            'product_thumbnail' => $save_url,
            'updated_at' => Carbon::now()
        ]);

        $notification = [
            'message' => 'Product Thumbnail Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } //End Method

    public function UpdateProductMultiImage(Request $request)
    {
        $imgs = $request->multi_img;

        foreach ($imgs as $id => $image) {
            $imgDel = MultiImg::findOrFail($id);
            unlink($imgDel->photo_name);

            $make_name = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(800, 800)->save('upload/products/multi-images/' . $make_name);

            $upload_path = 'upload/products/multi-images/' . $make_name;

            MultiImg::where('id', $id)->update([
                'photo_name' => $upload_path,
                'updated_at' => Carbon::now()
            ]);
        }
        $notification = [
            'message' => 'Product Multi Image Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } //End Method

    public function ProductMultiImgaeDelete($id)
    {
        $oldImg = MultiImg::findOrFail($id);
        unlink($oldImg->photo_name);

        MultiImg::findOrFail($id)->delete();

        $notification = [
            'message' => 'Product Multi Image Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } //End Methdd

    public function ProductDeactivate($id)
    {
        Product::findOrFail($id)->update([
            'status' => 0,
        ]);

        $notification = [
            'message' => 'Product Deactivated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } //End Methdd

    public function ProductActivate($id)
    {
        Product::findOrFail($id)->update([
            'status' => 1,
        ]);

        $notification = [
            'message' => 'Product Activated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } //End Methdd

    public function DeleteProduct($id)
    {
        $product = Product::findOrFail($id);
        unlink($product->product_thumbnail);
        Product::findOrFail($id)->delete();

        $images = MultiImg::where('product_id', $id)->get();

        foreach ($images as $image) {
            unlink($image->photo_name);
            MultiImg::where('product_id', $id)->delete();
        }
        $notification = [
            'message' => 'Product Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } //End Methdd
}
