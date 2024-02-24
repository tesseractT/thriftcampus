@extends('frontend.master_dashboard')
@section('main')

@section('title')
    Thrift Campus E-Stores | {{ $breadsubcat->category->category_name }} > {{ $breadsubcat->subcategory_name }}
@endsection

<div class="page-header mt-30 mb-50">
    <div class="container">
        <div class="archive-header">
            <div class="row align-items-center">
                <div class="col-xl-3">
                    <h5 class="mb-15">{{ $breadsubcat->subcategory_name }}</h5>
                    <div class="breadcrumb">
                        <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                        <span></span> {{ $breadsubcat->category->category_name }}<span></span>
                        {{ $breadsubcat->subcategory_name }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="container mb-30">
    <div class="row flex-row-reverse">
        <div class="col-lg-4-5">
            <div class="shop-product-fillter">
                <div class="totall-product">
                    <p>We found <strong class="text-brand">{{ count($products) }}</strong> items for you!</p>
                </div>
                <div class="sort-by-product-area">
                    <div class="sort-by-cover mr-10">
                        <div class="sort-by-product-wrap">
                            <div class="sort-by">
                                <span><i class="fi-rs-apps"></i>Show:</span>
                            </div>
                            <div class="sort-by-dropdown-wrap">
                                <span> 50 <i class="fi-rs-angle-small-down"></i></span>
                            </div>
                        </div>
                        <div class="sort-by-dropdown">
                            <ul>
                                <li><a class="active" href="#">50</a></li>
                                <li><a href="#">100</a></li>
                                <li><a href="#">150</a></li>
                                <li><a href="#">200</a></li>
                                <li><a href="#">All</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="sort-by-cover">
                        <div class="sort-by-product-wrap">
                            <div class="sort-by">
                                <span><i class="fi-rs-apps-sort"></i>Sort by:</span>
                            </div>
                            <div class="sort-by-dropdown-wrap">
                                <span> Featured <i class="fi-rs-angle-small-down"></i></span>
                            </div>
                        </div>
                        <div class="sort-by-dropdown">
                            <ul>
                                <li><a class="active" href="#">Featured</a></li>
                                <li><a href="#">Price: Low to High</a></li>
                                <li><a href="#">Price: High to Low</a></li>
                                <li><a href="#">Release Date</a></li>
                                <li><a href="#">Avg. Rating</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row product-grid">
                @foreach ($products as $prod)
                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                        <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".1s">
                            <div class="product-img-action-wrap">
                                <div class="product-img product-img-zoom">
                                    <a href="{{ url('product/details/' . $prod->id . '/' . $prod->product_slug) }}">
                                        <img class="default-img" src="{{ asset($prod->product_thumbnail) }}"
                                            alt="" />
                                        <img class="hover-img" src="{{ asset($prod->product_thumbnail) }}"
                                            alt="" />
                                    </a>
                                </div>
                                <div class="product-action-1">
                                    <a aria-label="Add To Wishlist" class="action-btn" id="{{ $prod->id }}"
                                        onclick="addToWishList(this.id)"><i class="fi-rs-heart"></i></a>
                                    <a aria-label="Compare" class="action-btn" id="{{ $prod->id }}"
                                        onclick="addToCompare(this.id)"><i class="fi-rs-shuffle"></i></a>
                                    <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal"
                                        data-bs-target="#quickViewModal" id="{{ $prod->id }}"
                                        onclick="productView(this.id)"><i class="fi-rs-eye"></i></a>
                                </div>

                                @php
                                    $amount = $prod->selling_price - $prod->discount_price;
                                    $discount = ($amount / $prod->selling_price) * 100;
                                @endphp
                                <div class="product-badges product-badges-position product-badges-mrg">
                                    @if ($prod->discount_price == null)
                                        <span class="new">New</span>
                                    @else
                                        <span class="hot">{{ round($discount) }}% Off!</span>
                                    @endif

                                </div>
                            </div>
                            <div class="product-content-wrap">
                                <div class="product-category">
                                    <a href="shop-grid-right.html">{{ $prod['subcategory']['subcategory_name'] }}</a>
                                </div>
                                <h2><a
                                        href="{{ url('product/details/' . $prod->id . '/' . $prod->product_slug) }}">{{ $prod->product_name }}</a>
                                </h2>
                                <div class="product-rate-cover">
                                    <div class="product-rate d-inline-block">
                                        <div class="product-rating" style="width: 90%"></div>
                                    </div>
                                    <span class="font-small ml-5 text-muted"> (4.0)</span>
                                </div>
                                <div>

                                    @if ($prod->vendor_id == null)
                                        <span class="font-small text-muted">By <a href="vendor-details-1.html">Thrift
                                                Campus</a></span>
                                    @else
                                        <span class="font-small text-muted">By <a
                                                href="vendor-details-1.html">{{ $prod['vendor']['name'] }}</a></span>
                                    @endif

                                </div>
                                <div class="product-card-bottom">
                                    @if ($prod->discount_price == null)
                                        <div class="product-price">
                                            <span>${{ $prod->selling_price }}</span>
                                        </div>
                                    @else
                                        <div class="product-price">
                                            <span>${{ $prod->discount_price }}</span>
                                            <span class="old-price">${{ $prod->selling_price }}</span>
                                        </div>
                                    @endif

                                    <div class="add-cart">
                                        <a class="add"
                                            href="{{ url('product/details/' . $prod->id . '/' . $prod->product_slug) }}"><i
                                                class="fi-rs-shopping-cart mr-5"></i>Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!--end product card-->





            </div>
            <!--product grid-->
            <div class="pagination-area mt-20 mb-20">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-start">
                        <li class="page-item">
                            <a class="page-link" href="#"><i class="fi-rs-arrow-small-left"></i></a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item active"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link dot" href="#">...</a></li>
                        <li class="page-item"><a class="page-link" href="#">6</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#"><i class="fi-rs-arrow-small-right"></i></a>
                        </li>
                    </ul>
                </nav>
            </div>

            <!--End Deals-->


        </div>
        <div class="col-lg-1-5 primary-sidebar sticky-sidebar">
            <div class="sidebar-widget widget-category-2 mb-30">
                <h5 class="section-title style-1 mb-30">Category</h5>
                <ul>
                    @foreach ($categories as $category)
                        @php
                            $products = App\Models\Product::where('category_id', $category->id)->get();
                        @endphp
                        <li>
                            <a href="shop-grid-right.html"> <img src="{{ asset($category->category_image) }}"
                                    alt="" />{{ $category->category_name }}</a><span
                                class="count">{{ count($products) }}</span>
                        </li>
                    @endforeach

                </ul>
            </div>

            <!-- Product sidebar Widget -->
            <div class="sidebar-widget product-sidebar mb-30 p-30 bg-grey border-radius-10">
                <h5 class="section-title style-1 mb-30">New products</h5>

                @foreach ($newProduct as $product)
                    <div class="single-post clearfix">
                        <div class="image">
                            <img src="{{ asset($product->product_thumbnail) }}" alt="#" />
                        </div>
                        <div class="content pt-10">
                            <p><a
                                    href="{{ url('product/details/' . $product->id . '/' . $product->product_slug) }}">{{ $product->product_name }}</a>
                            </p>
                            @if ($product->discount_price == null)
                                <p class="price mb-0 mt-5">${{ $product->selling_price }}</p>
                            @else
                                <p class="price mb-0 mt-5">${{ $product->discount_price }}</p>
                            @endif

                            <div class="product-rate">
                                <div class="product-rating" style="width: 90%"></div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

        </div>
    </div>
</div>
@endsection
