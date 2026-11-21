@extends('frontend.layouts.app')

@section('content')
    {{-- Categories , Sliders . Today's deal --}}
    <div class="home-banner-area mb-4 pt-0">
        <div class="container-fluid" style='padding-left: 0px;padding-right: 0px;margin: auto;'>
            <div class="row position-relative">
                {{-- <div class="col-lg-3 position-static d-none d-lg-block">
                    @include('frontend.partials.category_menu')
                </div> --}}

                @php
                    $num_todays_deal = count(filter_products(\App\Product::where('published', 1)->where('todays_deal', 1 ))->get());
                    $featured_categories = \App\Category::where('featured', 1)->get();
                @endphp

                <div class="@if($num_todays_deal > 0) col-md-12 @else col-md-12 @endif">
                    @if (get_setting('home_slider_images') != null)
                        <div class="aiz-carousel dots-inside-bottom mobile-img-auto-height" data-arrows="true" data-dots="true" data-autoplay="true" data-infinite="true">
                            @php $slider_images = json_decode(get_setting('home_slider_images'), true);  @endphp
                            @foreach ($slider_images as $key => $value)
                                @php
                                    $sliderImageUrl = uploaded_asset($value);
                                    $sliderImageHeight = count($featured_categories) == 0 ? 457 : 315;
                                @endphp
                                <div class="carousel-box">
                                    <a href="{{ data_get(json_decode(get_setting('home_slider_links'), true), $key, '#') }}">
                                        @if ($sliderImageUrl)
                                        <img
                                            class="d-block mw-100 img-fit rounded shadow-sm"
                                            src="{{ $sliderImageUrl }}"
                                            alt="{{ env('APP_NAME')}} promo"
                                            height="{{ $sliderImageHeight }}"
                                            onerror="this.onerror=null;this.classList.add('d-none');this.nextElementSibling.classList.remove('d-none');"
                                        >
                                        @endif
                                        <div class="{{ $sliderImageUrl ? 'd-none' : '' }} bg-light text-muted d-flex flex-column align-items-center justify-content-center rounded shadow-sm" role="img" aria-label="{{ translate('No image available') }}" style="width: 100%; height: {{ $sliderImageHeight }}px;">
                                            <i class="las la-image fs-1"></i>
                                            <span>{{ translate('No image available') }}</span>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                @if($num_todays_deal > 0)
                <div class="col-lg-2 order-3 mt-3 mt-lg-0">
                    <div class="bg-white rounded shadow-sm">
                        <div class="bg-soft-primary rounded-top p-3 d-flex align-items-center justify-content-center">
                            <span class="fw-600 fs-16 mr-2 text-truncate">
                                {{ translate('Todays Deal') }}
                            </span>
                            <span class="badge badge-primary badge-inline">{{ translate('Hot') }}</span>
                        </div>
                        <div class="c-scrollbar-light overflow-auto h-lg-400px p-2 bg-primary rounded-bottom">
                            <div class="gutters-5 lg-no-gutters row row-cols-2 row-cols-lg-1">
                            @foreach (filter_products(\App\Product::where('published', 1)->where('todays_deal', '1'))->get() as $key => $product)
                                @if ($product != null)
                                <div class="col mb-2">
                                    @include('common.product_item', ['product' => $product])
                                </div>
                                @endif
                            @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>

    {{-- Category sections: category title, its products, then its banner. --}}
    <div id="section_home_categories"></div>

    {{-- Banner section 1 --}}
    @if (get_setting('home_banner1_images') != null)
    <div class="mb-4">
        <div class="container-fluid" style='padding:0px;'>
            <div class="row">
                @php $banner_1_imags = json_decode(get_setting('home_banner1_images')); @endphp
                @foreach ($banner_1_imags as $key => $value)
                    <div class="col-xl col-md-12">
                        <div class="mb-3 mb-lg-0">
                            <a href="{{ data_get(json_decode(get_setting('home_banner1_links'), true), $key, '#') }}" class="d-block text-reset text-center">
                                <img src="{{ static_asset('assets/img/no-image-rect.svg') }}" data-src="{{ uploaded_asset($banner_1_imags[$key]) }}" alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload w-100" style="max-height: 380px; object-fit: contain;" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/no-image-rect.svg') }}';">
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif


    {{-- Flash Deal --}}
    @php
        $flash_deal = \App\FlashDeal::where('status', 1)->where('featured', 1)->first();
    @endphp
    @if($flash_deal != null && strtotime(date('Y-m-d H:i:s')) >= $flash_deal->start_date && strtotime(date('Y-m-d H:i:s')) <= $flash_deal->end_date)
    {{-- section 1 --}}
    <section class="mb-4">
        <div class="container-fluid">
            <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">

                <div class="d-flex flex-wrap mb-3 align-items-baseline border-bottom">
                    <h3 class="h5 fw-700 mb-0">
                        <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Flash Sale') }}</span>
                    </h3>
                    <div class="aiz-count-down ml-auto ml-lg-3 align-items-center" data-date="{{ date('Y/m/d H:i:s', $flash_deal->end_date) }}"></div>
                    <a href="{{ route('flash-deal-details', $flash_deal->slug) }}" class="ml-auto mr-0 btn btn-primary btn-sm shadow-md w-100 w-md-auto">{{ translate('View More') }}</a>
                </div>

                <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="5" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true' data-infinite='true'>
                    @foreach ($flash_deal->flash_deal_products as $key => $flash_deal_product)
                        @php
                            $product = \App\Product::find($flash_deal_product->product_id);
                        @endphp
                        @if ($product != null && $product->published != 0)
                            <div class="carousel-box">
                                @include('common.product_item', ['product' => $product])
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- Featured Section --}}
    <div id="section_featured">

    </div>
    
    {{-- new ads between featured and best selling --}}
    @if (get_setting('home_banner3_images') != null)
    <div class="mb-4">
        <div class="container-fluid">
            <div class="row">
                @php $banner_3_imags = json_decode(get_setting('home_banner3_images')); @endphp
                @foreach ($banner_3_imags as $key => $value)
                    <div class="col-xl col-md-12">
                        <div class="mb-3 mb-lg-0">
                            <a href="{{ data_get(json_decode(get_setting('home_banner3_links'), true), $key, '#') }}" class="d-block text-reset text-center">
                                <img src="{{ static_asset('assets/img/no-image-rect.svg') }}" data-src="{{ uploaded_asset($banner_3_imags[$key]) }}" alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload w-100" style="max-height: 380px; object-fit: contain;" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/no-image-rect.svg') }}';">
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
    {{-- end new ads between featured and best selling --}}

    {{-- Best Selling  --}}
    <div id="section_best_selling">

    </div>


    {{-- Banner Section 2 --}}
    @if (get_setting('home_banner2_images') != null)
    <div class="mb-4">
        <div class="container-fluid">
            <div class="row">
                @php $banner_2_imags = json_decode(get_setting('home_banner2_images')); @endphp
                @foreach ($banner_2_imags as $key => $value)
                    <div class="col-xl col-md-12">
                        <div class="mb-3 mb-lg-0">
                            <a href="{{ data_get(json_decode(get_setting('home_banner2_links'), true), $key, '#') }}" class="d-block text-reset text-center">
                                <img src="{{ static_asset('assets/img/no-image-rect.svg') }}" data-src="{{ uploaded_asset($banner_2_imags[$key]) }}" alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload w-100" style="max-height: 380px; object-fit: contain;" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/no-image-rect.svg') }}';">
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- Banner Section 2 --}}
   {{-- @if (get_setting('home_banner3_images') != null)
    <div class="mb-4">
        <div class="container-fluid">
            <div class="row">
                @php $banner_3_imags = json_decode(get_setting('home_banner3_images')); @endphp
                @foreach ($banner_3_imags as $key => $value)
                    <div class="col-xl col-md-12">
                        <div class="mb-3 mb-lg-0">
                            <a href="{{ data_get(json_decode(get_setting('home_banner3_links'), true), $key, '#') }}" class="d-block text-reset text-center">
                                <img src="{{ static_asset('assets/img/no-image-rect.svg') }}" data-src="{{ uploaded_asset($banner_3_imags[$key]) }}" alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload w-100" style="max-height: 380px; object-fit: contain;" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/no-image-rect.svg') }}';">
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif --}}

@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $.post('{{ route('home.section.featured') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#section_featured').html(data);
                AIZ.plugins.slickCarousel();
            });
            $.post('{{ route('home.section.best_selling') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#section_best_selling').html(data);
                AIZ.plugins.slickCarousel();
            });
            $.post('{{ route('home.section.home_categories') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#section_home_categories').html(data);
                AIZ.plugins.slickCarousel();
            });

            @if (\App\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1)
            $.post('{{ route('home.section.best_sellers') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#section_best_sellers').html(data);
                AIZ.plugins.slickCarousel();
            });
            @endif
        });
    </script>
@endsection
