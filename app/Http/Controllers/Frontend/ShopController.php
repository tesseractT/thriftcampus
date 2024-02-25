<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\MultiImg;
use App\Models\Product;

class ShopController extends Controller
{
    public function ShopPage()
    {
        $products = Product::query();

        if (!empty($_GET['category'])) {
            $slugs = explode(',', $_GET['category']);
            $catIds = Category::select('id')->whereIn('category_slug', $slugs)->pluck('id')->toArray();
            $products = Product::whereIn('category_id', $catIds)->get();
        } else if (!empty($_GET['brand'])) {
            $slugs = explode(',', $_GET['brand']);
            $brandIds = Brand::select('id')->whereIn('brand_slug', $slugs)->pluck('id')->toArray();
            $products = Product::whereIn('brand_id', $brandIds)->get();
        } else {
            $products = Product::where('status', 1)->orderBy('id', 'desc')->get();
        }

        $categories = Category::orderBy('category_name', 'asc')->get();
        $newProduct = Product::orderBy('id', 'desc')->limit(3)->get();
        $brands = Brand::orderBy('brand_name', 'asc')->get();

        return view('frontend.product.shop_page', compact('products', 'categories', 'newProduct', 'brands'));
    } //End Method

    public function ShopFilter(Request $request)
    {
        $data = $request->all();

        /// Category Filter

        $catUrl = "";
        if (!empty($data['category'])) {
            foreach ($data['category'] as $category) {
                if (empty($catUrl)) {
                    $catUrl .= '&category=' . $category;
                } else {
                    $catUrl .= ',' . $category;
                }
            }
        }

        /// Brand Filter
        $brandUrl = "";
        if (!empty($data['brand'])) {
            foreach ($data['brand'] as $brand) {
                if (empty($brandUrl)) {
                    $brandUrl .= '&brand=' . $brand;
                } else {
                    $brandUrl .= ',' . $brand;
                }
            }
        }
        return redirect()->route('shop.page', $catUrl . $brandUrl);
    } //End Method
}
