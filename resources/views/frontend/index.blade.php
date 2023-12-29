@extends('frontend.master_dashboard')
@section('main')
    @include('frontend.home.home_slider')
    <!--End hero slider-->

    @include('frontend.home.home_featured_category')
    <!--End category slider-->

    @include('frontend.home.home_banner')
    <!--End banners-->

    @include('frontend.home.home_new_product')
    <!--Products Tabs-->

    @include('frontend.home.home_featured_product')
    <!--Featured Product-->









    <!-- #1 Category -->

    <section class="product-tabs section-padding position-relative">
        <div class="container">
            <div class="section-title style-2 wow animate__animated animate__fadeIn">
                <h3>{{ $skip_category_0->category_name }} Category </h3>

            </div>
            <!--End nav-tabs-->
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                    <div class="row product-grid-4">



                        @foreach ($skip_product_0 as $prod)
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
            </div>
            <!--End tab-content-->
        </div>
    </section>
    <!--End #1 Category -->





    <!-- #3 Category -->

    <section class="product-tabs section-padding position-relative">
        <div class="container">
            <div class="section-title style-2 wow animate__animated animate__fadeIn">
                <h3>{{ $skip_category_2->category_name }} Category </h3>

            </div>
            <!--End nav-tabs-->
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                    <div class="row product-grid-4">



                        @foreach ($skip_product_2 as $prod)
                            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn"
                                    data-wow-delay=".1s">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a
                                                href="{{ url('product/details/' . $prod->id . '/' . $prod->product_slug) }}">
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
            </div>
            <!--End tab-content-->
        </div>
    </section>
    <!--End #3 Category -->








    <!-- #9 Category -->

    {{-- <section class="product-tabs section-padding position-relative">
        <div class="container">
            <div class="section-title style-2 wow animate__animated animate__fadeIn">
                <h3>{{ $skip_category_7->category_name }} Category </h3>

            </div>
            <!--End nav-tabs-->
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                    <div class="row product-grid-4">



                        @foreach ($skip_product_7 as $prod)
                            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn"
                                    data-wow-delay=".1s">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a
                                                href="{{ url('product/details/' . $prod->id . '/' . $prod->product_slug) }}">
                                                <img class="default-img" src="{{ asset($prod->product_thumbnail) }}"
                                                    alt="" />
                                                <img class="hover-img" src="{{ asset($prod->product_thumbnail) }}"
                                                    alt="" />
                                            </a>
                                        </div>
                                        <div class="product-action-1">
                                           <a aria-label="Add To Wishlist" class="action-btn" id="{{ $prod->id }}"
                                            onclick="addToWishList(this.id)"><i class="fi-rs-heart"></i></a>
                                        <a aria-label="Compare" class="action-btn"  id="{{ $prod->id }}"
                                            onclick="addToCompare(this.id)"><i
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
            </div>
            <!--End tab-content-->
        </div>
    </section> --}}
    <!--End #9 Category -->







    <section class="section-padding mb-30">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0 wow animate__animated animate__fadeInUp"
                    data-wow-delay="0">
                    <h4 class="section-title style-1 mb-30 animated animated"> Hot Deals </h4>
                    <div class="product-list-small animated animated">
                        @foreach ($hot_deals as $hot)
                            <article class="row align-items-center hover-up">
                                <figure class="col-md-4 mb-0">
                                    <a href="{{ url('product/details/' . $hot->id . '/' . $hot->product_slug) }}"><img
                                            src="{{ asset($hot->product_thumbnail) }}" alt="" /></a>
                                </figure>
                                <div class="col-md-8 mb-0">
                                    <h6>
                                        <a href="shop-product-right.html">{{ $hot->product_name }}</a>
                                    </h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    @if ($hot->discount_price == null)
                                        <div class="product-price mt-10">
                                            <span>${{ $hot->selling_price }} </span>
                                        </div>
                                    @else
                                        <div class="product-price mt-10">
                                            <span>${{ $hot->discount_price }} </span>
                                            <span class="old-price">${{ $hot->selling_price }}</span>
                                        </div>
                                    @endif
                                </div>
                            </article>
                        @endforeach

                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 mb-md-0 wow animate__animated animate__fadeInUp"
                    data-wow-delay=".1s">
                    <h4 class="section-title style-1 mb-30 animated animated"> Special Offer </h4>
                    <div class="product-list-small animated animated">
                        @foreach ($special_offers as $special)
                            <article class="row align-items-center hover-up">
                                <figure class="col-md-4 mb-0">
                                    <a href="{{ url('product/details/' . $special->id . '/' . $special->product_slug) }}"><img
                                            src="{{ asset($special->product_thumbnail) }}" alt="" /></a>
                                </figure>
                                <div class="col-md-8 mb-0">
                                    <h6>
                                        <a href="shop-product-right.html">{{ $special->product_name }}</a>
                                    </h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    @if ($special->discount_price == null)
                                        <div class="product-price mt-10">
                                            <span>${{ $special->selling_price }} </span>
                                        </div>
                                    @else
                                        <div class="product-price mt-10">
                                            <span>${{ $special->discount_price }} </span>
                                            <span class="old-price">${{ $special->selling_price }}</span>
                                        </div>
                                    @endif
                                </div>
                            </article>
                        @endforeach

                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0 d-none d-lg-block wow animate__animated animate__fadeInUp"
                    data-wow-delay=".2s">
                    <h4 class="section-title style-1 mb-30 animated animated">Recently added</h4>
                    <div class="product-list-small animated animated">
                        @foreach ($latest as $latest)
                            <article class="row align-items-center hover-up">
                                <figure class="col-md-4 mb-0">
                                    <a href="{{ url('product/details/' . $latest->id . '/' . $latest->product_slug) }}"><img
                                            src="{{ asset($latest->product_thumbnail) }}" alt="" /></a>
                                </figure>
                                <div class="col-md-8 mb-0">
                                    <h6>
                                        <a href="shop-product-right.html">{{ $latest->product_name }}</a>
                                    </h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    @if ($latest->discount_price == null)
                                        <div class="product-price mt-10">
                                            <span>${{ $latest->selling_price }} </span>
                                        </div>
                                    @else
                                        <div class="product-price mt-10">
                                            <span>${{ $latest->discount_price }} </span>
                                            <span class="old-price">${{ $latest->selling_price }}</span>
                                        </div>
                                    @endif
                                </div>
                            </article>
                        @endforeach

                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0 d-none d-xl-block wow animate__animated animate__fadeInUp"
                    data-wow-delay=".3s">
                    <h4 class="section-title style-1 mb-30 animated animated"> Special Deals </h4>
                    <div class="product-list-small animated animated">
                        @foreach ($special_deals as $special)
                            <article class="row align-items-center hover-up">
                                <figure class="col-md-4 mb-0">
                                    <a href="{{ url('product/details/' . $special->id . '/' . $special->product_slug) }}"><img
                                            src="{{ asset($special->product_thumbnail) }}" alt="" /></a>
                                </figure>
                                <div class="col-md-8 mb-0">
                                    <h6>
                                        <a href="shop-product-right.html">{{ $special->product_name }}</a>
                                    </h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                    @if ($special->discount_price == null)
                                        <div class="product-price mt-10">
                                            <span>${{ $special->selling_price }} </span>
                                        </div>
                                    @else
                                        <div class="product-price mt-10">
                                            <span>${{ $special->discount_price }} </span>
                                            <span class="old-price">${{ $special->selling_price }}</span>
                                        </div>
                                    @endif
                                </div>
                            </article>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End 4 columns-->









    <!--Vendor List -->


    @include('frontend.home.home_vendor_list')

    <!--End Vendor List -->
@endsection
