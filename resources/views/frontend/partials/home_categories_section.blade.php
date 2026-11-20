@php $home_categories = json_decode(get_setting('home_categories')); @endphp
@foreach ($home_categories as $key => $value)
    @php $category = \App\Category::find($value); @endphp
    {{-- title --}}
    <section class="container-fluid">
            <div class="col-12 text-left electromobile-title" >
              <h1>{{ $category->getTranslation('name') }}<span ><a href="{{ route('products.category', $category->slug) }}" class="ml-auto mr-0 btn btn-primary btn-sm shadow-md">{{ translate('View More') }}</a></span></h1>
            </div>
            {{-- categories --}}
            @foreach (\App\Category::where('id',$value)->get()->take(11)  as  $category)
              <div class="row align-content-center align-items-center d-flex justify-content-center text-center mb-4">
                @php
                  $num_cats = count(\App\Category::where('parent_id', $category->id)->get());
                  if($num_cats){
                    $cols = 12 / $num_cats;
                  $ceil_cols = ceil($cols);
                  }else{
                    $ceil_cols = 6;
                  }
                @endphp
                  @foreach (\App\Category::where('parent_id', $category->id)->get() as $cat)
                  

                  <div class="col-md-2 col-6 electromobile">
                    <div class="electromobile-content">
                      <a href="{{ route('products.category', $cat->slug) }}" class="jalal-img" style="background-image: url('{{ uploaded_asset($cat->banner) }}')"></a>
                      <h3><div class="text-truncate fs-16 fw-600 mt-2 opacity-70">{{ $cat->getTranslation('name') }}</div></h3>
                    </div>
                  </div>

                      {{-- <li class="minw-0 mt-3 text-center">
                          <a href="{{ route('products.category', $cat->slug) }}" class="d-block rounded bg-white p-2 text-reset shadow-sm" style="width:120px;height:120px;border-radius:100%!important;">
                              <img
                                  src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                  data-src="{{ uploaded_asset($cat->banner) }}"
                                  alt="{{ $cat->getTranslation('name') }}"
                                  class="lazyload img-fit"
                                  
                                  style="height: 100px;width: 100px;border-radius: 100%;object-fit: cover;"
                                  onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';"
                              >
                              <div class="text-truncate fs-16 fw-600 mt-2 opacity-70">{{ $cat->getTranslation('name') }}</div>
                          </a>
                      </li> --}}
                  @endforeach
              </div>
            @endforeach
            {{-- papular --}}
            <section class="mb-4">
                <div class="container-fluid">
                    <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                        <div class="d-flex mb-3 align-items-baseline border-bottom">
                            <h3 class="h5 fw-700 mb-0">
                                <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">
                                  {{ translate('Best Seller') }}</span>
                            </h3>
                            <a href="{{ route('products.category', $category->slug) }}" class="ml-auto mr-0 btn btn-primary btn-sm shadow-md">{{ translate('View More') }}</a>
                        </div>
                        <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="7" data-xl-items="7" data-lg-items="6"  data-md-items="4" data-sm-items="3" data-xs-items="2" data-arrows='true' data-infinite='true'>
                            @foreach (filter_products(\App\Product::where('published', 1)->where('subsubcategory_id',$value)->orderBy('id', 'desc'))->limit(12)->get() as $key => $product)
                              <div class="carousel-box" >
                                  @include('common.product_item', ['product' => $product])
                              </div>
                          @endforeach
                        </div>
                    </div>
                </div>
            </section>
            <br>
            {{-- latest --}}
            <section class="mb-4">
                <div class="container-fluid">
                    <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                        <div class="d-flex mb-3 align-items-baseline border-bottom">
                            <h3 class="h5 fw-700 mb-0">
                                <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Recently Arrived') }}</span>
                            </h3>
                            <a href="{{ route('products.category', $category->slug) }}" class="ml-auto mr-0 btn btn-primary btn-sm shadow-md">{{ translate('View More') }}</a>
                        </div>
                        <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="7" data-xl-items="7" data-lg-items="6"  data-md-items="4" data-sm-items="3" data-xs-items="2" data-arrows='true' data-infinite='true'>
                          @foreach (filter_products(\App\Product::where('published', 1)->where('subsubcategory_id',$value)->orderBy('num_of_sale', 'desc'))->limit(12)->get() as $key => $product)
                              <div class="carousel-box">
                                  @include('common.product_item', ['product' => $product])
                              </div>
                          @endforeach
                        </div>
                    </div>
                </div>
            </section>
            <br>
            {{-- slide of category --}}
            <section>
              <div class="aiz-carousel dots-inside-bottom mobile-img-auto-height" data-arrows="true" data-dots="true" data-autoplay="true" data-infinite="true">            
                      @foreach (\App\Catslide::where('category_id', $value)->get()  as  $slider)
                      <div class="carousel-box">
                        <a href="#">
                              <img
                                class="d-block mw-100 img-fit rounded shadow-sm"
                                src="{{ $slider->name }}"
                                height="250"
                                onerror="this.onerror=null;this.src='{{ uploaded_asset($slider->logo) }}';"
                            >
                        </a>
                    </div>
                      @endforeach
              </div>
            </section>

    </section>
@endforeach
