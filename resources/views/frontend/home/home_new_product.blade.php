@php
    $products = App\Models\Product::where('status', 1)
        ->orderBy('id', 'asc')
        ->limit(10)
        ->get();
    $categories = App\Models\Category::orderBy('category_name', 'asc')->get();
@endphp

<section class="product-tabs section-padding position-relative">
    <div class="container">
        <div class="section-title style-2 wow animate__animated animate__fadeIn">
            <h3> New Products </h3>
            <ul class="nav nav-tabs links" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="nav-tab-one" data-bs-toggle="tab" data-bs-target="#tab-one"
                        type="button" role="tab" aria-controls="tab-one" aria-selected="true">All</button>
                </li>
                @foreach ($categories as $cat)
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="nav-tab-two" data-bs-toggle="tab" href="#category{{ $cat->id }}"
                            type="button" role="tab" aria-controls="tab-two"
                            aria-selected="false">{{ $cat->category_name }}</a>
                    </li>
                @endforeach

            </ul>
        </div>
        <!--End nav-tabs-->
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                <div class="row product-grid-4">

                    @foreach ($products as $prod)
                        <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                            <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn"
                                data-wow-delay=".1s">
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
                                        <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i
                                                class="fi-rs-shuffle"></i></a>
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
                                        <a href="shop-grid-right.html">{{ $prod['category']['category_name'] }}</a>
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
                                            <span class="font-small text-muted">By <a
                                                    href="vendor-details-1.html">Thrift Campus</a></span>
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
                                            <a class="add" href="shop-cart.html"><i
                                                    class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <!--end product card-->


                </div>
                <!--End product-grid-4-->
            </div>
            <!--En tab one-->
            @foreach ($categories as $cat)
                <div class="tab-pane fade" id="category{{ $cat->id }}" role="tabpanel" aria-labelledby="tab-two">
                    <div class="row product-grid-4">


                        @php
                            $catGetProduct = App\Models\Product::where('category_id', $cat->id)
                                ->orderBy('id', 'DESC')
                                ->get();
                        @endphp
                        @forelse ($catGetProduct as $prod)
                            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn"
                                    data-wow-delay=".1s">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a
                                                href="{{ url('product/details/' . $prod->id . '/' . $prod->product_slug) }}">
                                                <img class="default-img" src="{{ asset($prod->product_thumbnail) }}"
                                                    alt="" />
                                                {{-- <img class="hover-img"
                                                src="{{ asset('frontend/assets/imgs/shop/product-1-2.jpg') }}"
                                                alt="" /> --}}
                                            </a>
                                        </div>
                                        <div class="product-action-1">
                                            <a aria-label="Add To Wishlist" class="action-btn"
                                                id="{{ $prod->id }}" onclick="addToWishList(this.id)"><i
                                                    class="fi-rs-heart"></i></a>
                                            <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i
                                                    class="fi-rs-shuffle"></i></a>
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
                                            <a
                                                href="shop-grid-right.html">{{ $prod['category']['category_name'] }}</a>
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
                                                <span class="font-small text-muted">By <a
                                                        href="vendor-details-1.html">Thrift Campus</a></span>
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
                                                <a class="add" href="shop-cart.html"><i
                                                        class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end product card-->
                        @empty

                            <h5 class="text-danger">NO PRODUCT AVAILABLE</h5>
                        @endforelse

                    </div>
                    <!--End product-grid-4-->
                </div>
                <!--En tab two-->
            @endforeach

        </div>
        <!--End tab-content-->
    </div>
</section>
