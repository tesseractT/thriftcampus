<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\MultiImg;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;

class IndexController extends Controller
{
    public function ProductDetails($id, $slug)
    {
        $product = Product::findOrFail($id);

        $color = $product->product_color;
        $product_color = explode(',', $color);

        $size = $product->product_size;
        $product_size = explode(',', $size);

        $cat_id = $product->category_id;
        $relatedProduct = Product::where('category_id', $cat_id)->where('id', '!=', $id)->limit(4)->get();

        $multi_img = MultiImg::where('product_id', $id)->get();

        return view('frontend.product.product_details', compact('product', 'product_color', 'product_size', 'multi_img', 'relatedProduct'));
    } //End Method
}