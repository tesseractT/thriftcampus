@php
    $featured = App\Models\Product::where('featured', 1)
        ->orderBy('id', 'DESC')
        ->limit(6)
        ->get();
@endphp


<section class="section-padding pb-5">
    <div class="container">
        <div class="section-title wow animate__animated animate__fadeIn">
            <h3 class=""> Featured Products </h3>

        </div>
        <div class="row">
            <div class="col-lg-3 d-none d-lg-flex wow animate__animated animate__fadeIn">
                <div class="banner-img style-2">
                    <div class="banner-text">
                        <h2 class="mb-100">Bring nature into your home</h2>
                        <a href="shop-grid-right.html" class="btn btn-xs">Shop Now <i
                                class="fi-rs-arrow-small-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-12 wow animate__animated animate__fadeIn" data-wow-delay=".4s">
                <div class="tab-content" id="myTabContent-1">
                    <div class="tab-pane fade show active" id="tab-one-1" role="tabpanel" aria-labelledby="tab-one-1">
                        <div class="carausel-4-columns-cover arrow-center position-relative">
                            <div class="slider-arrow slider-arrow-2 carausel-4-columns-arrow"
                                id="carausel-4-columns-arrows"></div>
                            <div class="carausel-4-columns carausel-arrow-center" id="carausel-4-columns">

                                @foreach ($featured as $prod)
                                    <div class="product-cart-wrap">
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
                                                <a aria-label="Quick view" class="action-btn small hover-up"
                                                    data-bs-toggle="modal" data-bs-target="#quickViewModal"> <i
                                                        class="fi-rs-eye"></i></a>
                                                <a aria-label="Add To Wishlist" class="action-btn small hover-up"
                                                    href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                                <a aria-label="Compare" class="action-btn small hover-up"
                                                    href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
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
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 80%"></div>
                                            </div>
                                            @if ($prod->discount_price == null)
                                                <div class="product-price mt-10">
                                                    <span>${{ $prod->selling_price }} </span>
                                                </div>
                                            @else
                                                <div class="product-price mt-10">
                                                    <span>${{ $prod->discount_price }} </span>
                                                    <span class="old-price">${{ $prod->selling_price }}</span>
                                                </div>
                                            @endif

                                            <div class="sold mt-15 mb-15">
                                                <div class="progress mb-5">
                                                    <div class="progress-bar" role="progressbar" style="width: 50%"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <a href="shop-cart.html" class="btn w-100 hover-up"><i
                                                    class="fi-rs-shopping-cart mr-5"></i>Add To Cart</a>
                                        </div>
                                    </div>
                                    <!--End product Wrap-->
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!--End tab-pane-->


                </div>
                <!--End tab-content-->
            </div>
            <!--End Col-lg-9-->
        </div>
    </div>
</section>
