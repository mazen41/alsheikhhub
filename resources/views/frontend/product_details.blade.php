@extends('frontend.layouts.app')

@section('meta_title'){{ $detailedProduct->meta_title }}@stop

@section('meta_description'){{ $detailedProduct->meta_description }}@stop

@section('meta_keywords'){{ $detailedProduct->tags }}@stop

@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $detailedProduct->meta_title }}">
    <meta itemprop="description" content="{{ $detailedProduct->meta_description }}">
    <meta itemprop="image" content="{{ uploaded_asset($detailedProduct->meta_img) }}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="{{ $detailedProduct->meta_title }}">
    <meta name="twitter:description" content="{{ $detailedProduct->meta_description }}">
    <meta name="twitter:creator" content="@author_handle">
    <meta name="twitter:image" content="{{ uploaded_asset($detailedProduct->meta_img) }}">
    <meta name="twitter:data1" content="{{ single_price($detailedProduct->unit_price) }}">
    <meta name="twitter:label1" content="Price">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $detailedProduct->meta_title }}" />
    <meta property="og:type" content="og:product" />
    <meta property="og:url" content="{{ route('product', $detailedProduct->slug) }}" />
    <meta property="og:image" content="{{ uploaded_asset($detailedProduct->meta_img) }}" />
    <meta property="og:description" content="{{ $detailedProduct->meta_description }}" />
    <meta property="og:site_name" content="{{ get_setting('meta_title') }}" />
    <meta property="og:price:amount" content="{{ single_price($detailedProduct->unit_price) }}" />
    <meta property="product:price:currency" content="{{ \App\Currency::findOrFail(\App\BusinessSetting::where('type', 'system_default_currency')->first()->value)->code }}" />
    <meta property="fb:app_id" content="{{ env('FACEBOOK_PIXEL_ID') }}">
@endsection

@section('content')
    @php
        $photos = array_values(array_filter(array_map('trim', explode(',', (string) $detailedProduct->photos)), function ($imageId) {
            return !empty(uploaded_asset($imageId));
        }));
        $stockPhotos = $detailedProduct->stocks->filter(function ($stock) {
            return !empty($stock->image) && !empty(uploaded_asset($stock->image));
        });
        $hasProductImages = count($photos) > 0 || $stockPhotos->isNotEmpty();
    @endphp
    <section class="mb-4 pt-3">
        <div class="container-fluid">
            <div class="bg-white shadow-sm rounded p-3">
                <div class="row">
                    @if ($hasProductImages)
                    <div class="col-xl-5 col-lg-5 mb-4">
                        <div class="sticky-top z-3 row gutters-10">
                            <div class="col order-1 order-md-2">
                                <div class="aiz-carousel product-gallery" data-nav-for='.product-gallery-thumb' data-fade='true' data-auto-height='true'>
                                    @foreach ($stockPhotos as $key => $stock)
                                        @if ($stock->image != null)
                                            <div class="carousel-box img-zoom rounded">
                                                <img
                                                    class="img-fluid lazyload"
                                                    src="{{ uploaded_asset($stock->image) }}"
                                                    data-src="{{ uploaded_asset($stock->image) }}"
                                                    onerror="this.onerror=null;this.closest('.carousel-box').remove();"
                                                >
                                            </div>
                                        @endif
                                    @endforeach
                                    @foreach ($photos as $key => $photo)
                                        <div class="carousel-box img-zoom rounded">
                                            <img
                                                class="img-fluid lazyload"
                                                src="{{ uploaded_asset($photo) }}"
                                                data-src="{{ uploaded_asset($photo) }}"
                                                onerror="this.onerror=null;this.closest('.carousel-box').remove();"
                                            >
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-12 col-md-auto w-md-80px order-2 order-md-1 mt-3 mt-md-0">
                                <div class="aiz-carousel product-gallery-thumb" data-items='5' data-nav-for='.product-gallery' data-vertical='true' data-vertical-sm='false' data-focus-select='true' data-arrows='true'>
                                    @foreach ($stockPhotos as $key => $stock)
                                        @if ($stock->image != null)
                                            <div class="carousel-box c-pointer border p-1 rounded" data-variation="{{ $stock->variant }}">
                                                <img
                                                    class="lazyload mw-100 size-50px mx-auto"
                                                    src="{{ uploaded_asset($stock->image) }}"
                                                    data-src="{{ uploaded_asset($stock->image) }}"
                                                    onerror="this.onerror=null;this.closest('.carousel-box').remove();"
                                                >
                                            </div>
                                        @endif
                                    @endforeach
                                    @foreach ($photos as $key => $photo)
                                    <div class="carousel-box c-pointer border p-1 rounded">
                                        <img
                                            class="lazyload mw-100 size-50px mx-auto"
                                            src="{{ uploaded_asset($photo) }}"
                                            data-src="{{ uploaded_asset($photo) }}"
                                            onerror="this.onerror=null;this.closest('.carousel-box').remove();"
                                        >
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="@if ($hasProductImages) col-xl-7 col-lg-7 @else col-12 @endif">
                        <div class="text-left">
                            <h1 class="mb-2 fs-20 fw-600" style="line-height: inherit;">
                                {{ $detailedProduct->getTranslation('name') }}
                            </h1>

                            <div class="row align-items-center">
                                <div class="col-12 text-right">
                                    @php
                                        $qty = 0;
                                        if($detailedProduct->variant_product){
                                            foreach ($detailedProduct->stocks as $key => $stock) {
                                                $qty += $stock->qty;
                                            }
                                        }
                                        else{
                                            $qty = $detailedProduct->current_stock;
                                        }
                                    @endphp
                                    @if ($qty > 0)
                                        <span class="badge badge-md badge-inline badge-pill badge-success">{{ translate('In stock')}}</span>
                                    @else
                                        <span class="badge badge-md badge-inline badge-pill badge-danger">{{ translate('Out of stock')}}</span>
                                    @endif
                                </div>
                                {{-- <div class="col-auto">
                                    <small class="mr-2 opacity-100">{{ translate('Estimate Shipping Time')}}: </small>
                                    @if ($detailedProduct->est_shipping_days)
                                        {{ $detailedProduct->est_shipping_days }} {{  translate('Days') }}
                                    @endif
                                </div> --}}
                            </div>

                            <hr>
                            
                            @if(home_price($detailedProduct->id) != home_discounted_price($detailedProduct->id))

                                <div class="row no-gutters mt-3">
                                    <div class="col-sm-4">
                                        <div class="opacity-100 my-2">{{ translate('Price Before Descount')}}:</div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="fs-20 opacity-100" style="padding-top: 5px;">
                                            <del>
                                                {{ home_price($detailedProduct->id) }}
                                                @if($detailedProduct->unit != null)
                                                    <span>/{{ $detailedProduct->getTranslation('unit') }}</span>
                                                @endif
                                            </del>
                                        </div>
                                    </div>
                                </div>

                                <div class="row no-gutters my-2">
                                    <div class="col-sm-4">
                                        <div class="opacity-100">{{ translate('Price After Discount')}}:</div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div>
                                            <strong class="h4 fw-600 text-primary" style="font-family: 'Tajawal';">
                                                {{ home_discounted_price($detailedProduct->id) }}
                                            </strong>
                                            @if($detailedProduct->unit != null)
                                                <span class="opacity-100">/{{ $detailedProduct->getTranslation('unit') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="row no-gutters mt-3">
                                    <div class="col-sm-2">
                                        <div class="opacity-100 my-2">{{ translate('Price')}}:</div>
                                    </div>
                                    <div class="col-sm-10">
                                        <div>
                                            <strong class="h4 fw-600 text-primary" style="font-family: 'Tajawal';">
                                                {{ home_discounted_price($detailedProduct->id) }}
                                            </strong>
                                            @if($detailedProduct->unit != null)
                                                <span class="opacity-100">/{{ $detailedProduct->getTranslation('unit') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Addon::where('unique_identifier', 'club_point')->first()->activated && $detailedProduct->earn_point > 0)
                                <div class="row no-gutters mt-4">
                                    <div class="col-sm-4">
                                        <div class="opacity-100 my-2">{{  translate('Club Point') }}:</div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="d-inline-block rounded px-2 bg-soft-primary border-soft-primary border">
                                            <span class="strong-700">{{ $detailedProduct->earn_point }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <hr>

                            <div class="row align-items-center">
                                @if ($detailedProduct->brand != null)
                                    <div class="col-auto">
                                        <a href="{{ route('products.brand',$detailedProduct->brand->slug) }}">
                                            <img src="{{ uploaded_asset($detailedProduct->brand->logo) }}" alt="{{ $detailedProduct->brand->getTranslation('name') }}" height="70">
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <hr>

                            

                            <form id="option-choice-form">
                                @csrf
                                <input type="hidden" name="id" value="{{ $detailedProduct->id }}">

                                @if ($detailedProduct->choice_options != null)
                                    @foreach (json_decode($detailedProduct->choice_options) as $key => $choice)

                                    <div class="row no-gutters">
                                        <div class="col-sm-4">
                                            <div class="opacity-100 my-2">{{ \App\Attribute::find($choice->attribute_id)->getTranslation('name') }}:</div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="aiz-radio-inline">
                                                @foreach ($choice->values as $key => $value)
                                                <label class="aiz-megabox pl-0 mr-2">
                                                    <input
                                                        type="radio"
                                                        name="attribute_id_{{ $choice->attribute_id }}"
                                                        value="{{ $value }}"
                                                        @if($key == 0) checked @endif
                                                    >
                                                    <span class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center py-0 px-3 mb-2">
                                                        {{ $value }}
                                                    </span>
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    @endforeach
                                @endif

                                @if (count(json_decode($detailedProduct->colors)) > 0)
                                    <div class="row no-gutters">
                                        <div class="col-sm-3">
                                            <div class="opacity-100 my-2">{{ translate('Color')}}:</div>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="aiz-radio-inline">
                                                @foreach (json_decode($detailedProduct->colors) as $key => $color)
                                                <label class="aiz-megabox pl-0 mr-2" data-toggle="tooltip" data-title="{{ \App\Color::where('code', $color)->first()->name }}">
                                                    <input
                                                        type="radio"
                                                        name="color"
                                                        value="{{ \App\Color::where('code', $color)->first()->name }}"
                                                        @if($key == 0) checked @endif
                                                    >
                                                    <span class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center p-1 mb-2">
                                                        <span class="size-30px d-inline-block rounded" style="background: {{ $color }};"></span>
                                                    </span>
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                @endif

                                <!-- Quantity + Add to cart -->
                                <div class="row no-gutters">
                                    <div class="col-sm-2">
                                        <div class="opacity-100 my-2">{{ translate('Quantity')}}:</div>
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="product-quantity d-flex align-items-center">
                                            <div class="row no-gutters align-items-center aiz-plus-minus mr-3" style="width: 130px;">
                                                <button class="btn col-auto btn-icon btn-sm btn-circle btn-light" type="button" data-type="minus" data-field="quantity" disabled="">
                                                    <i class="las la-minus"></i>
                                                </button>
                                                <input type="text" name="quantity" class="col border-0 text-center flex-grow-1 fs-16 input-number" placeholder="1" value="{{ $detailedProduct->min_qty }}" min="{{ $detailedProduct->min_qty }}" max="10" readonly>
                                                <button class="btn  col-auto btn-icon btn-sm btn-circle btn-light" type="button" data-type="plus" data-field="quantity">
                                                    <i class="las la-plus"></i>
                                                </button>
                                            </div>
                                            <div class="avialable-amount opacity-100">
                                                @if($detailedProduct->stock_visibility_state != 'hide')
                                                (<span id="available-quantity">{{ $qty }}</span> {{ translate('available')}})
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row no-gutters pb-3 d-none" id="chosen_price_div">
                                    <div class="col-sm-4">
                                        <div class="opacity-100 my-2">{{ translate('Total Price')}}:</div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="product-price">
                                            <strong id="chosen_price" class="h4 fw-600 text-primary" style="font-family: 'Tajawal';">

                                            </strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                  <small class="mr-2 opacity-100">{{ translate('Estimate Shipping Time')}}: </small>
                                  @if ($detailedProduct->est_shipping_days)
                                  {{ $detailedProduct->est_shipping_days }} {{ translate('Days') }}
                                  @endif
                                </div>


                            </form>

                            <div class="mt-3">
                                @if ($qty > 0)
                                    <button type="button" class="btn btn-soft-primary mr-2 add-to-cart fw-600" onclick="addToCart()">
                                        <i class="las la-shopping-bag"></i>
                                        <span class="d-none d-md-inline-block"> {{ translate('Add to cart')}}</span>
                                    </button>
                                    <button type="button" class="btn btn-primary buy-now fw-600" onclick="buyNow()">
                                        <i class="la la-shopping-cart"></i> {{ translate('Buy Now')}}
                                    </button>
                                @else
                                    <button type="button" class="btn btn-secondary fw-600" disabled>
                                        <i class="la la-cart-arrow-down"></i> {{ translate('Out of Stock')}}
                                    </button>
                                @endif
                            </div>



                            <div class="d-table width-100 mt-3">
                                <div class="d-table-cell">
                                    <!-- Add to wishlist button -->
                                    <button type="button" class="btn pl-0 btn-link fw-600" onclick="addToWishList({{ $detailedProduct->id }})">
                                        {{ translate('Add to wishlist')}}
                                    </button>
                                    <!-- Add to compare button -->
                                    <button type="button" class="btn btn-link btn-icon-left fw-600" onclick="addToCompare({{ $detailedProduct->id }})">
                                        {{ translate('Add to compare')}}
                                    </button>
                                    @if(Auth::check() && \App\Addon::where('unique_identifier', 'affiliate_system')->first() != null && \App\Addon::where('unique_identifier', 'affiliate_system')->first()->activated && (\App\AffiliateOption::where('type', 'product_sharing')->first()->status || \App\AffiliateOption::where('type', 'category_wise_affiliate')->first()->status) && Auth::user()->affiliate_user != null && Auth::user()->affiliate_user->status)
                                        @php
                                            if(Auth::check()){
                                                if(Auth::user()->referral_code == null){
                                                    Auth::user()->referral_code = substr(Auth::user()->id.Str::random(10), 0, 10);
                                                    Auth::user()->save();
                                                }
                                                $referral_code = Auth::user()->referral_code;
                                                $referral_code_url = URL::to('/product').'/'.$detailedProduct->slug."?product_referral_code=$referral_code";
                                            }
                                        @endphp
                                        <div>
                                            <button type=button id="ref-cpurl-btn" class="btn btn-sm btn-secondary" data-attrcpy="{{ translate('Copied')}}" onclick="CopyToClipboard(this)" data-url="{{$referral_code_url}}">{{ translate('Copy the Promote Link')}}</button>
                                        </div>
                                    @endif
                                </div>
                            </div>


                            @php
                                $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();
                                $refund_sticker = \App\BusinessSetting::where('type', 'refund_sticker')->first();
                            @endphp
                            @if ($refund_request_addon != null && $refund_request_addon->activated == 1 && $detailedProduct->refundable)
                                <div class="row no-gutters mt-4">
                                    <div class="col-sm-2">
                                        <div class="opacity-100 my-2">{{ translate('Refund')}}:</div>
                                    </div>
                                    <div class="col-sm-10">
                                        <a href="{{ route('returnpolicy') }}" target="_blank">
                                            @if ($refund_sticker != null && $refund_sticker->value != null)
                                                <img src="{{ uploaded_asset($refund_sticker->value) }}" height="36">
                                            @else
                                                <img src="{{ static_asset('assets/img/refund-sticker.jpg') }}" height="36">
                                            @endif
                                        </a>
                                        <a href="{{ route('returnpolicy') }}" class="ml-2" target="_blank">{{ translate('View Policy') }}</a>
                                    </div>
                                </div>
                            @endif
                            

                            <div class="row no-gutters mt-4">
                                <div class="col-sm-2">
                                    <div class="opacity-100 my-2">{{ translate('Share')}}:</div>
                                </div>
                                <div class="col-sm-10">
                                    <div class="aiz-share"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>


@endsection

@section('modal')
    <!-- Modal -->
    <div class="modal fade" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-zoom" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600">{{ translate('Login')}}</h6>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="p-3">
                        <form class="form-default" role="form" action="{{ route('cart.login.submit') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                @if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated)
                                    <input type="text" class="form-control h-auto form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{ translate('Email Or Phone')}}" name="email" id="email">
                                @else
                                    <input type="email" class="form-control h-auto form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{  translate('Email') }}" name="email">
                                @endif
                                @if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated)
                                    <span class="opacity-100">{{  translate('Use country code before number') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <input type="password" name="password" class="form-control h-auto form-control-lg" placeholder="{{ translate('Password')}}">
                            </div>

                            <div class="row mb-2">
                                <div class="col-6">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <span class=opacity-100>{{  translate('Remember Me') }}</span>
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                                <div class="col-6 text-right">
                                    <a href="{{ route('password.request') }}" class="text-reset opacity-100 fs-14">{{ translate('Forgot password?')}}</a>
                                </div>
                            </div>

                            <div class="mb-5">
                                <button type="submit" class="btn btn-primary btn-block fw-600">{{  translate('Login') }}</button>
                            </div>
                        </form>

                        <div class="text-center mb-3">
                            <p class="text-muted mb-0">{{ translate('Dont have an account?')}}</p>
                            <a href="{{ route('user.registration') }}">{{ translate('Register Now')}}</a>
                        </div>
                        @if(\App\BusinessSetting::where('type', 'google_login')->first()->value == 1 || \App\BusinessSetting::where('type', 'facebook_login')->first()->value == 1 || \App\BusinessSetting::where('type', 'twitter_login')->first()->value == 1)
                            <div class="separator mb-3">
                                <span class="bg-white px-3 opacity-100">{{ translate('Or Login With')}}</span>
                            </div>
                            <ul class="list-inline social colored text-center mb-5">
                                @if (\App\BusinessSetting::where('type', 'facebook_login')->first()->value == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="facebook">
                                            <i class="lab la-facebook-f"></i>
                                        </a>
                                    </li>
                                @endif
                                @if(\App\BusinessSetting::where('type', 'google_login')->first()->value == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ route('social.login', ['provider' => 'google']) }}" class="google">
                                            <i class="lab la-google"></i>
                                        </a>
                                    </li>
                                @endif
                                @if (\App\BusinessSetting::where('type', 'twitter_login')->first()->value == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ route('social.login', ['provider' => 'twitter']) }}" class="twitter">
                                            <i class="lab la-twitter"></i>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            getVariantPrice();
    	});

        function CopyToClipboard(e) {
            var url = $(e).data('url');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(url).select();
            try {
                document.execCommand("copy");
                AIZ.plugins.notify('success', '{{ translate('Link copied to clipboard') }}');
            } catch (err) {
                AIZ.plugins.notify('danger', '{{ translate('Oops, unable to copy') }}');
            }
            $temp.remove();
            // if (document.selection) {
            //     var range = document.body.createTextRange();
            //     range.moveToElementText(document.getElementById(containerid));
            //     range.select().createTextRange();
            //     document.execCommand("Copy");

            // } else if (window.getSelection) {
            //     var range = document.createRange();
            //     document.getElementById(containerid).style.display = "block";
            //     range.selectNode(document.getElementById(containerid));
            //     window.getSelection().addRange(range);
            //     document.execCommand("Copy");
            //     document.getElementById(containerid).style.display = "none";

            // }
            // AIZ.plugins.notify('success', 'Copied');
        }


    </script>
    <script>
        function updateUserStatus() {
            //alert('warning');
            $(".jssocials-share-whatsapp").attr("style", "margin-right: 10px!important;");
        }
        setTimeout(function () {
            updateUserStatus();
        }, 1000);
    </script>
@endsection
