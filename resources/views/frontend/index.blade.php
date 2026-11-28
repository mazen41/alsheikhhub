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

                <div class="col-12">
                    @if (get_setting('home_slider_images') != null)
                        @php
                            $slider_images = json_decode(get_setting('home_slider_images'), true) ?: [];
                            $seenSliderImages = [];
                            $slider_images = array_filter($slider_images, function ($imageId) use (&$seenSliderImages) {
                                $imageUrl = uploaded_asset($imageId);
                                if (!$imageUrl || in_array($imageUrl, $seenSliderImages, true)) {
                                    return false;
                                }
                                $seenSliderImages[] = $imageUrl;
                                return true;
                            });
                        @endphp
                        @if (count($slider_images) > 0)
                        <div class="aiz-carousel dots-inside-bottom mobile-img-auto-height" data-arrows="true" data-dots="true" data-autoplay="true" data-infinite="true">
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
                                            onerror="this.onerror=null;this.closest('.carousel-box').remove();"
                                        >
                                        @endif
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        @endif
                    @endif
                </div>

            </div>
        </div>
    </div>

    @if($num_todays_deal > 0)
        <section class="mb-4 today-deal-section">
            <div class="container-fluid">
                <div class="bg-white rounded shadow-sm p-3">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                        <h2 class="h5 fw-700 mb-0">{{ translate('Todays Deal') }}</h2>
                        <span class="badge badge-primary badge-inline">{{ translate('Hot') }}</span>
                    </div>
                    <div class="row gutters-10 row-cols-1 row-cols-sm-2 row-cols-lg-4">
                        @foreach (filter_products(\App\Product::where('published', 1)->where('todays_deal', '1'))->take(1)->get() as $product)
                            @if ($product != null)
                                <div class="col mb-2">
                                    @include('common.product_item', ['product' => $product])
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Category sections: category title, its products, then its banner. --}}
    <div id="section_home_categories"></div>


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
            $.post('{{ route('home.section.home_categories') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#section_home_categories').html(data);
                AIZ.plugins.slickCarousel();
            });
        });
    </script>
@endsection
