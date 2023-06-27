<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SubCategoryController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('frontend.index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'UserDashboard'])->name('dashboard');
    Route::get('/user/logout', [UserController::class, 'UserDestroy'])->name('user.logout');
    Route::post('/user/profile/store', [UserController::class, 'UserProfileStore'])->name('user.profile.store');
    Route::post('/user/update/password', [UserController::class, 'UserUpdatePassword'])->name('user.update.password');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

//Admin Dashboard
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminDestroy'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('update.password');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
});

//Vendor Dashboard
Route::middleware(['auth', 'role:vendor'])->group(function () {
    Route::get('/vendor/dashboard', [VendorController::class, 'VendorDashboard'])->name('vendor.dashboard');
    Route::get('/vendor/logout', [VendorController::class, 'VendorDestroy'])->name('vendor.logout');
    Route::get('/vendor/profile', [VendorController::class, 'VendorProfile'])->name('vendor.profile');
    Route::get('/vendor/change/password', [VendorController::class, 'VendorChangePassword'])->name('vendor.change.password');
    Route::post('/vendor/update/password', [VendorController::class, 'VendorUpdatePassword'])->name('vendor.update.password');
    Route::post('/vendor/profile/store', [VendorController::class, 'VendorProfileStore'])->name('vendor.profile.store');
});

//Login routes
Route::get('/admin/login', [AdminController::class, 'AdminLogin']);
Route::get('/vendor/login', [VendorController::class, 'VendorLogin'])->name('vendor.login');
Route::get('/become/vendor', [VendorController::class, 'BecomeVendor'])->name('become.vendor');
Route::post('/vendor/register', [VendorController::class, 'VendorRegister'])->name('vendor.register');



Route::middleware(['auth', 'role:admin'])->group(function () {

    //Brands routes
    Route::controller(BrandController::class)->group(function () {
        Route::get('all/brand', 'AllBrand')->name('all.brand');
        Route::get('add/brand', 'AddBrand')->name('add.brand');
        Route::get('edit/brand/{id}', 'EditBrand')->name('edit.brand');
        Route::get('delete/brand/{id}', 'DeleteBrand')->name('delete.brand');
        Route::post('store/brand', 'StoreBrand')->name('store.brand');
        Route::post('update/brand', 'UpdateBrand')->name('update.brand');
    });

    //Category routes
    Route::controller(CategoryController::class)->group(function () {
        Route::get('all/category', 'AllCategory')->name('all.category');
        Route::get('add/category', 'AddCategory')->name('add.category');
        Route::get('edit/category/{id}', 'EditCategory')->name('edit.category');
        Route::get('delete/category/{id}', 'DeleteCategory')->name('delete.category');
        Route::post('store/category', 'StoreCategory')->name('store.category');
        Route::post('update/category', 'UpdateCategory')->name('update.category');
    });

    //SubCategory routes
    Route::controller(SubCategoryController::class)->group(function () {
        Route::get('all/subcategory', 'AllSubCategory')->name('all.subcategory');
        Route::get('add/subcategory', 'AddSubCategory')->name('add.subcategory');
        Route::post('store/subcategory', 'StoreSubCategory')->name('store.subcategory');
        Route::get('edit/subcategory/{id}', 'EditSubCategory')->name('edit.subcategory');
        Route::post('update/subcategory', 'UpdateSubCategory')->name('update.subcategory');
        Route::get('delete/subcategory/{id}', 'DeleteSubCategory')->name('delete.subcategory');
        Route::get('/subcategory/ajax/{category_id}', 'GetSubCategory');
    });

    //Vendor routes
    Route::controller(AdminController::class)->group(function () {
        Route::get('inactive/vendor', 'InactiveVendor')->name('inactive.vendor');
        Route::get('active/vendor', 'ActiveVendor')->name('active.vendor');
        Route::get('inactive/vendor/details/{id}', 'InactiveVendorDetails')->name('inactive.vendor.details');
        Route::get('active/vendor/details/{id}', 'ActiveVendorDetails')->name('active.vendor.details');
        Route::post('active/vendor/approve', 'ActiveVendorApprove')->name('active.vendor.approve');
        Route::post('active/vendor/disapprove', 'ActiveVendorDisapprove')->name('active.vendor.disapprove');
    });

    //Product routes
    Route::controller(ProductController::class)->group(function () {
        Route::get('all/product', 'AllProduct')->name('all.product');
        Route::get('add/product', 'AddProduct')->name('add.product');
        Route::get('edit/product/{id}', 'EditProduct')->name('edit.product');
        Route::get('product/multi_image/delete/{id}', 'ProductMultiImgaeDelete')->name('product.multi_image.delete');
        Route::post('store/product', 'StoreProduct')->name('store.product');
        Route::post('update/product', 'UpdateProduct')->name('update.product');
        Route::post('update/product/thumbnail', 'UpdateProductThumbnail')->name('update.product.thumbnail');
        Route::post('update/product/multi_image', 'UpdateProductMultiImage')->name('update.product.multi_image');
    });
});
