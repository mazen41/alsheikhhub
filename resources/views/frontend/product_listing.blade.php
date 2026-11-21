@extends('frontend.layouts.app')

@if (isset($category_id))
    @php
        $meta_title = \App\Category::find($category_id)->meta_title;
        $meta_description = \App\Category::find($category_id)->meta_description;
    @endphp
@elseif (isset($brand_id))
    @php
        $meta_title = \App\Brand::find($brand_id)->meta_title;
        $meta_description = \App\Brand::find($brand_id)->meta_description;
    @endphp
@else
    @php
        $meta_title         = get_setting('meta_title');
        $meta_description   = get_setting('meta_description');
    @endphp
@endif

@section('meta_title'){{ $meta_title }}@stop
@section('meta_description'){{ $meta_description }}@stop

@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $meta_title }}">
    <meta itemprop="description" content="{{ $meta_description }}">

    <!-- Twitter Card data -->
    <meta name="twitter:title" content="{{ $meta_title }}">
    <meta name="twitter:description" content="{{ $meta_description }}">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $meta_title }}" />
    <meta property="og:description" content="{{ $meta_description }}" />
@endsection

@php
    $currentCategory = isset($category_id) ? \App\Category::find($category_id) : null;
    $isSubcategory = $currentCategory && $currentCategory->parent_id != 0;
@endphp

@section('content')
    {{-- Child categories --}}
    @php
        $directSubcategories = $currentCategory
            ? \App\Category::where('parent_id', $currentCategory->id)->get()
            : collect();
    @endphp
    @if ($directSubcategories->isNotEmpty())
        <ul class="list-unstyled mb-3 row gutters-5 text-center align-items-center justify-content-center" style="gap: 10px;">
            @foreach ($directSubcategories as $cat)
                <li class="minw-0 mt-0 text-center" style="padding-bottom: 40px;">
                    @php $categoryBanner = uploaded_asset($cat->banner); @endphp
                    <a href="{{ route('products.category', $cat->slug) }}" class="d-block rounded bg-white p-2 text-reset shadow-sm" style="width:150px;min-height:100px;border-radius:12px!important;">
                        @if ($categoryBanner)
                            <img
                                src="{{ $categoryBanner }}"
                                alt="{{ $cat->getTranslation('name') }}"
                                class="img-fit"
                                style="height:100px;width:135px;object-fit:cover;"
                                onerror="this.onerror=null;this.remove();"
                            >
                        @endif
                        <div class="text-truncate fs-12 fw-600 mt-2 opacity-100" style="padding:10px;">{{ $cat->getTranslation('name') }}</div>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif

    {{-- 3- offers --}}
    @php
        $banner4Images = json_decode(get_setting('home_banner4_images') ?: '[]', true) ?: [];
        $banner4Categories = json_decode(get_setting('home_banner4_categories') ?: '[]', true) ?: [];
        $banner4Links = json_decode(get_setting('home_banner4_links') ?: '[]', true) ?: [];
        $matchingBanners4 = [];
        foreach ($banner4Images as $key => $imageId) {
            $imageUrl = uploaded_asset($imageId);
            if ($currentCategory && (int) data_get($banner4Categories, $key, 0) === (int) $currentCategory->id && $imageUrl) {
                $matchingBanners4[] = ['image' => $imageUrl, 'link' => data_get($banner4Links, $key, '#')];
            }
        }
    @endphp
    @if (count($matchingBanners4) > 0)
      <div class="mb-4">
          <div class="container-fluid">
              <div class="row gutters-10">
                  @foreach ($matchingBanners4 as $banner)
                      <div class="col-xl col-md-6">
                          <div class="mb-3 mb-lg-0">
                              <a href="{{ $banner['link'] }}" class="d-block text-reset text-center">
                                  <img src="{{ $banner['image'] }}" alt="{{ env('APP_NAME') }} promo" class="img-fluid w-100" style="max-height: 380px; object-fit: contain;" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/no-image-rect.svg') }}';">
                              </a>
                          </div>
                      </div>
                  @endforeach
              </div>
          </div>
      </div>
    @endif
    @php
        $banner7Images = json_decode(get_setting('home_banner7_images') ?: '[]', true) ?: [];
        $banner7Categories = json_decode(get_setting('home_banner7_categories') ?: '[]', true) ?: [];
        $banner7Links = json_decode(get_setting('home_banner7_links') ?: '[]', true) ?: [];
        $matchingBanners7 = [];
        foreach ($banner7Images as $key => $imageId) {
            $imageUrl = uploaded_asset($imageId);
            if ($currentCategory && (int) data_get($banner7Categories, $key, 0) === (int) $currentCategory->id && $imageUrl) {
                $matchingBanners7[] = ['image' => $imageUrl, 'link' => data_get($banner7Links, $key, '#')];
            }
        }
    @endphp
    @if (count($matchingBanners7) > 0)
      <div class="mb-4">
          <div class="container-fluid">
              <div class="row gutters-10">
                  @foreach ($matchingBanners7 as $banner)
                      <div class="col-xl col-md-6">
                          <div class="mb-3 mb-lg-0">
                              <a href="{{ $banner['link'] }}" class="d-block text-reset text-center">
                                  <img src="{{ $banner['image'] }}" alt="{{ env('APP_NAME') }} promo" class="img-fluid w-100" style="max-height: 380px; object-fit: contain;" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/no-image-rect.svg') }}';">
                              </a>
                          </div>
                      </div>
                  @endforeach
              </div>
          </div>
      </div>
    @endif



  {{-- @if(\App\Category::finبلففd($category_id)->parent_id == 0) --}}

        @php
          $num_cats = count(\App\Category::where('parent_id', $category_id)->get());
        @endphp

        @if ($num_cats > 0)
            @foreach (\App\Category::where('parent_id', $category_id)->orderBy('order_level', 'desc')->get() as $subcategory)
                @php
                    $subcategoryIds = \App\Utility\CategoryUtility::children_ids($subcategory->id);
                    $subcategoryIds[] = $subcategory->id;
                    $subcategoryProducts = filter_products(
                        \App\Product::where('published', 1)
                            ->whereIn('category_id', $subcategoryIds)
                            ->orderBy('created_at', 'desc')
                    )->limit(12)->get();
                @endphp

                @if ($subcategoryProducts->isNotEmpty())
                    <section class="mb-4">
                        <div class="container-fluid">
                            <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                                <div class="d-flex mb-3 align-items-baseline border-bottom">
                                    <h2 class="h5 fw-700 mb-0">
                                        <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ $subcategory->getTranslation('name') }}</span>
                                    </h2>
                                    <a href="{{ route('products.category', $subcategory->slug) }}" class="ml-auto mr-0 btn btn-primary btn-sm shadow-md">{{ translate('View More') }}</a>
                                </div>
                                <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="5" data-lg-items="4" data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows="true" data-infinite="true">
                                    @foreach ($subcategoryProducts as $product)
                                        <div class="carousel-box">
                                            @include('common.product_item', ['product' => $product])
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </section>
                @endif
            @endforeach
        @endif

      {{-- products details --}}
       @if($num_cats == 0)
       <section class="mb-4 pt-3">
          <div class="container sm-px-0">
              <form class="" id="search-form" action="" method="GET">
                  <div class="row">
                       @if (!$currentCategory)
                       <div class="col-xl-3">
                          <div class="aiz-filter-sidebar collapse-sidebar-wrap sidebar-xl sidebar-right z-1035">
                              <div class="overlay overlay-fixed dark c-pointer" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" data-same=".filter-sidebar-thumb"></div>
                              <div class="collapse-sidebar c-scrollbar-light text-left">
                                  <div class="d-flex d-xl-none justify-content-between align-items-center pl-3 border-bottom">
                                      <h3 class="h6 mb-0 fw-600">{{ translate('Filters') }}</h3>
                                      <button type="button" class="btn btn-sm p-2 filter-sidebar-thumb" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" >
                                          <i class="las la-times la-2x"></i>
                                      </button>
                                  </div>
                                  <div class="bg-white shadow-sm rounded mb-3">
                                      <div class="fs-15 fw-600 p-3 border-bottom">
                                          {{ translate('Categories')}}
                                      </div>
                                      <div class="p-3">
                                          <ul class="list-unstyled">
                                              @if (!isset($category_id))
                                                  @foreach (\App\Category::where('level', 0)->get() as $category)
                                                      <li class="mb-2 ml-2">
                                                          <a class="text-reset fs-14" href="{{ route('products.category', $category->slug) }}">{{ $category->getTranslation('name') }}</a>
                                                      </li>
                                                  @endforeach
                                              @else
                                                  <li class="mb-2">
                                                      <a class="text-reset fs-14 fw-600" href="{{ route('search') }}">
                                                          <i class="las la-angle-left"></i>
                                                          {{ translate('All Categories')}}
                                                      </a>
                                                  </li>
                                                  @if (\App\Category::find($category_id)->parent_id != 0)
                                                      <li class="mb-2">
                                                          <a class="text-reset fs-14 fw-600" href="{{ route('products.category', \App\Category::find(\App\Category::find($category_id)->parent_id)->slug) }}">
                                                              <i class="las la-angle-left"></i>
                                                              {{ \App\Category::find(\App\Category::find($category_id)->parent_id)->getTranslation('name') }}
                                                          </a>
                                                      </li>
                                                  @endif
                                                  <li class="mb-2">
                                                      <a class="text-reset fs-14 fw-600" href="{{ route('products.category', \App\Category::find($category_id)->slug) }}">
                                                          <i class="las la-angle-left"></i>
                                                          {{ \App\Category::find($category_id)->getTranslation('name') }}
                                                      </a>
                                                  </li>
                                                  @foreach (\App\Utility\CategoryUtility::get_immediate_children_ids($category_id) as $key => $id)
                                                      <li class="ml-4 mb-2">
                                                          <a class="text-reset fs-14" href="{{ route('products.category', \App\Category::find($id)->slug) }}">{{ \App\Category::find($id)->getTranslation('name') }}</a>
                                                      </li>
                                                  @endforeach
                                              @endif
                                          </ul>
                                      </div>
                                  </div>
                                  <div class="bg-white shadow-sm rounded mb-3">
                                      <div class="fs-15 fw-600 p-3 border-bottom">
                                          {{ translate('Price range')}}
                                      </div>
                                      <div class="p-3">
                                          <div class="aiz-range-slider">
                                            
                                              <div style="display:none"
                                                  id="input-slider-range"
                                                  data-range-value-min="@if(count(\App\Product::query()->get()) < 1) 0 @else {{ filter_products(\App\Product::query())->get()->min('unit_price') }} @endif"
                                                  data-range-value-max="@if(count(\App\Product::query()->get()) < 1) 0 @else {{ filter_products(\App\Product::query())->get()->max('unit_price') }} @endif"
                                              ></div>

                                              <div class="row mt-2">
                                                <div class="col-6"><span style="font-size: 85%">{{ translate('From') }}</span>


                                                    <input type="number" class="range-slider-value value-low fs-12 fw-500 opacity-70"
                                                    style="width: 40px;"
                                                        @if (isset($min_price))
                                                            data-range-value-low="{{ $min_price }}"
                                                        @elseif($products->min('unit_price') > 0)
                                                            data-range-value-low="{{ $products->min('unit_price') }}"
                                                        @else
                                                            data-range-value-low="0"
                                                        @endif
                                                        id="input-slider-range-value-low"
                                                        value="{{ $products->min('unit_price') }}"
                                                    ><span style="font-size: 85%">{{ translate('R.S') }}</span>

                                                </div>
                                                <span><i class="fa fa-arrows-h"></i></span>
                                                <div class="col-6 text-right">{{ translate('To') }}
                                                    <input type="number" class="range-slider-value value-high fs-12 fw-500 opacity-70"
                                                    style="width: 40px;"
                                                        @if (isset($max_price))
                                                            data-range-value-high="{{ $max_price }}"
                                                        @elseif($products->max('unit_price') > 0)
                                                            data-range-value-high="{{ $products->max('unit_price') }}"
                                                        @else
                                                            data-range-value-high="0"
                                                        @endif
                                                        id="input-slider-range-value-high"
                                                        value="{{ $products->max('unit_price') }}"
                                                    >
                                                    <span style="font-size: 85%">{{ translate('R.S') }}</span>


                                                </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  @if($all_colors)
                                  <div class="bg-white shadow-sm rounded mb-3">
                                      <div class="fs-15 fw-600 p-3 border-bottom">
                                          {{ translate('Filter by color')}}
                                      </div>
                                      <div class="p-3">
                                          <div class="aiz-radio-inline">
                                              @foreach ($all_colors as $key => $color)
                                              <label class="aiz-megabox pl-0 mr-2" data-toggle="tooltip" data-title="{{ \App\Color::where('code', $color)->first()->name }}">
                                                  <input
                                                      type="radio"
                                                      name="color"
                                                      value="{{ $color }}"
                                                      onchange="filter()"
                                                      @if(isset($selected_color) && $selected_color == $color) checked @endif
                                                  >
                                                  <span class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center p-1 mb-2">
                                                      <span class="size-30px d-inline-block rounded" style="background: {{ $color }};"></span>
                                                  </span>
                                              </label>
                                              @endforeach
                                          </div>
                                      </div>
                                  </div>
                                  @endif

                                  @foreach ($attributes as $key => $attribute)
                                      @if (\App\Attribute::find($attribute['id']) != null && array_key_exists('values', $attribute) && $attribute['values'])
                                          <div class="bg-white shadow-sm rounded mb-3">
                                              <div class="fs-15 fw-600 p-3 border-bottom">
                                                  {{ translate('Filter by') }} {{ \App\Attribute::find($attribute['id'])->getTranslation('name') }}
                                              </div>
                                              <div class="p-3">
                                                  <div class="aiz-checkbox-list">
                                                      @if(array_key_exists('values', $attribute))
                                                          @foreach ($attribute['values'] as $key => $value)
                                                              @php
                                                                  $flag = false;
                                                                  if(isset($selected_attributes)){
                                                                      foreach ($selected_attributes as $key => $selected_attribute) {
                                                                          if($selected_attribute['id'] == $attribute['id']){
                                                                              if(in_array($value, $selected_attribute['values'])){
                                                                                  $flag = true;
                                                                                  break;
                                                                              }
                                                                          }
                                                                      }
                                                                  }
                                                              @endphp
                                                              <label class="aiz-checkbox">
                                                                  <input
                                                                      type="checkbox"
                                                                      name="attribute_{{ $attribute['id'] }}[]"
                                                                      value="{{ $value }}" @if ($flag) checked @endif
                                                                      onchange="filter()"
                                                                  >
                                                                  <span class="aiz-square-check"></span>
                                                                  <span>{{ $value }}</span>
                                                              </label>
                                                          @endforeach
                                                      @endif
                                                  </div>
                                              </div>
                                          </div>
                                      @endif
                                  @endforeach

                              </div>
                          </div>
                      </div>
                       @endif
                      
                       <div class="@if($currentCategory) col-xl-12 @else col-xl-9 @endif">
                          <ul class="breadcrumb bg-transparent p-0">
                              <li class="breadcrumb-item opacity-50">
                                  <a class="text-reset" href="{{ route('home') }}">{{ translate('Home')}}</a>
                              </li>
                              @if(!isset($category_id))
                                  <li class="breadcrumb-item fw-600  text-dark">
                                      <a class="text-reset" href="{{ route('search') }}">"{{ translate('All Categories')}}"</a>
                                  </li>
                              @else
                                  <li class="breadcrumb-item opacity-50">
                                      <a class="text-reset" href="{{ route('search') }}">{{ translate('All Categories')}}</a>
                                  </li>
                              @endif
                              @if(isset($category_id))
                                  <li class="text-dark fw-600 breadcrumb-item">
                                      <a class="text-reset" href="{{ route('products.category', \App\Category::find($category_id)->slug) }}">"{{ \App\Category::find($category_id)->getTranslation('name') }}"</a>
                                  </li>
                              @endif
                          </ul>

                          <div class="text-left">
                              <div class="d-flex align-items-center">
                                  <div>
                                      <h1 class="h6 fw-600 text-body">
                                          @if(isset($category_id))
                                              {{ \App\Category::find($category_id)->getTranslation('name') }}
                                          @elseif(isset($query))
                                              {{ translate('Search result for ') }}"{{ $query }}"
                                          @else
                                              {{ translate('All Products') }}
                                          @endif
                                      </h1>
                                  </div>
                                  @if ($isSubcategory)
                                      @php $parentCategory = \App\Category::find($currentCategory->parent_id); @endphp
                                      <div class="form-group mr-3">
                                          <a class="btn btn-sm btn-outline-secondary" href="{{ $parentCategory ? route('products.category', $parentCategory->slug) : route('home') }}">
                                              <i class="las la-angle-left"></i> {{ translate('Back') }}
                                          </a>
                                      </div>
                                  @else
                                  <div class="form-group ml-auto mr-0 w-200px d-none d-xl-block">
                                      <label class="mb-0 opacity-50">{{ translate('Brands')}}</label>
                                      <select class="form-control form-control-sm aiz-selectpicker" data-live-search="true" name="brand" onchange="filter()">
                                          <option value="">{{ translate('All Brands')}}</option>
                                          @foreach (\App\Brand::where('category_id', $category_id)->get() as $brand);
                                          {{-- @foreach (\App\Brand::all() as $brand) --}}
                                              <option value="{{ $brand->slug }}" @isset($brand_id) @if ($brand_id == $brand->id) selected @endif @endisset>{{ $brand->getTranslation('name') }}</option>
                                          @endforeach
                                      </select>
                                  </div>
                                  @endif
                                  <div class="form-group w-200px ml-0 ml-xl-3">
                                      <label class="mb-0 opacity-50">{{ translate('Sort by')}}</label>
                                      <select class="form-control form-control-sm aiz-selectpicker" name="sort_by" onchange="filter()">
                                          <option value="newest" @isset($sort_by) @if ($sort_by == 'newest') selected @endif @endisset>{{ translate('Newest')}}</option>
                                          <option value="oldest" @isset($sort_by) @if ($sort_by == 'oldest') selected @endif @endisset>{{ translate('Oldest')}}</option>
                                          <option value="price-asc" @isset($sort_by) @if ($sort_by == 'price-asc') selected @endif @endisset>{{ translate('Price low to high')}}</option>
                                          <option value="price-desc" @isset($sort_by) @if ($sort_by == 'price-desc') selected @endif @endisset>{{ translate('Price high to low')}}</option>
                                      </select>
                                  </div>
                                  @if (!$currentCategory)
                                  <div class="d-xl-none ml-auto ml-xl-3 mr-0 form-group align-self-end">
                                      <button type="button" class="btn btn-icon p-0" data-toggle="class-toggle" data-target=".aiz-filter-sidebar">
                                          <i class="la la-filter la-2x"></i>
                                      </button>
                                  </div>
                                  @endif
                              </div>
                          </div>
                          <input type="hidden" name="min_price" value="">
                          <input type="hidden" name="max_price" value="">
                          <div class="row gutters-5 justify-content-center row-cols-xxl-4 row-cols-xl-4 row-cols-lg-4 row-cols-md-3 row-cols-2">
                              @foreach ($products as $key => $product)
                              <div class="col mb-3">
                                   @include('common.product_item', ['product' => $product])
                              </div>
                              @endforeach
                          </div>
                          <div class="aiz-pagination aiz-pagination-center mt-4" style="padding-bottom: 20px;">
                              {{ $products->links() }}
                          </div>
                      </div>
                  </div>
              </form>
          </div>
      </section>
      @endif
      

  {{-- @endif --}}

@endsection

@section('script')
    <script type="text/javascript">
        function filter(){
            $('#search-form').submit();
        }
        function rangefilter(arg){
            $('input[name=min_price]').val(arg[0]);
            $('input[name=max_price]').val(arg[1]);
            filter();
        }
    </script>
    <script>
      $(document).ready(function () {
        $('#input-slider-range-value-low').on('change',function(){
          var low = $('#input-slider-range-value-low').val();
          // alert(low);
          
          setTimeout(function() {
            location.reload(true);
          }, 500);
        });
        $('#input-slider-range-value-high').on('change',function(){
          var high = $('#input-slider-range-value-high').val();
          // alert(high);

          setTimeout(function() {
            location.reload(true);
          }, 500);
        });
        
      });
    </script>
@endsection
