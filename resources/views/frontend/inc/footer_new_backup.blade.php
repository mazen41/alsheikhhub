</div>
<footer class="footer">
  <div class="col-12">
    <div class="row">

      {{-- <div class="footer-center col-lg-2 col-md-12">
        <div class="logo">
          <a href="{{ route('home') }}"><img src="{{ static_asset('citylolo/images/logo_wide.png') }}" alt="{{ env('APP_NAME') }}" style="width: auto; padding: 0px 20px; margin: 10px 0px; max-width: 180px;"></a>
        </div>
      </div> --}}
      <div class="">
          
           {{-- Banner Section 2 --}}
    @if (get_setting('home_banner6_images') != null)
    <div>
        <div class="container-fluid">
            <div class="row gutters-10">
                @php $banner_6_imags = json_decode(get_setting('home_banner6_images')); @endphp
                @foreach ($banner_6_imags as $key => $value)
                    <div class="col-xl col-md-12">
                        <div class="mb-3 mb-lg-0">
                            <a href="{{ json_decode(get_setting('home_banner6_links'), true)[$key] }}" class="d-block text-reset">
                                <img src="{{ static_asset('assets/img/no-image-rect.svg') }}" data-src="{{ uploaded_asset($banner_6_imags[$key]) }}" alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload">
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif 
          
          
          
        {{-- <div class="row">
          <div class="col-6">
            <div class="row">
              <div class="col-12">
                <div class="col-12 text-center">
                  <h3>نحن مستعدون دائماً لمساعدتك</h3>
                </div>
                <div class="col-12 text-center">
                  <p>تواصل معنا على قنوات التواصل التالية:</p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="row">
              <div class="col-12 text-left"><i class="fa fa-envelope"></i> <a href="mailto:info@citylolo.com" style="color:white;letter-spacing: 1px;">info@citylolo.com</a></div>
              <div class="col-12 text-left"><i class="fa fa-envelope"></i> <a href="mailto:relations@citylolo.com" style="color:white;letter-spacing: 1px;">relations@citylolo.com</a></div>
              <div class="col-12 text-left"><i class="fa fa-envelope"></i> <a href="mailto:support@citylolo.com" style="color:white;letter-spacing: 1px;">support@citylolo.com</a></div>
            </div>
          </div>
        </div> --}}

      </div>
    </div>
  </div>
  <br>
  <div class="col-12">
    <div class="col-12 underline"></div>
  </div>
  
  <section class="mb-4">
    <div class="container-fluid">
      <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
        <div class="d-flex mb-3 align-items-baseline border-bottom">
          <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="7" data-xl-items="7" data-lg-items="7"  data-md-items="4" data-sm-items="3" data-xs-items="2" data-arrows='true' data-infinite='true'>
            @foreach (\App\Category::where('level', 0)->orderBy('order_level', 'desc')->get()->take(7) as $category)
                <div style="border:0px solid red">
                  <div style="border:0px solid green;display: inline-block;width: 200px!important;">
                    <div class="position-relative">
                      <h4 style="font-size: 18px;">
                        <a href="{{ route('products.category', $category->slug) }}">{{ $category->getTranslation('name') }}</a>
                      </h4>
                      <ul style="font-size: 14px;padding: 0 20px 0 0;">
                        @foreach (\App\Category::where('parent_id', $category->id)->orderBy('order_level', 'desc')->get()->take(11)  as  $cate)
                          @if ($cate->parent_id == $category->id)
                          <li><a href="{{ url('category') }}/{{ $cate->slug }}" style="color:gray;line-height: 1;padding-right: 10px">{{ $cate->getTranslation('name') }} </a></li>
                          @endif
                        @endforeach
                      </ul>
                    </div>
                  </div>
                </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="col-12">
    <div class="col-12 underline"></div>
  </div>

  <div class="col-12 footer-apps text-center" style="padding:0;">
    <div class="row">
      <div class="col-md-4 footer-apps-content">
        <h1>{{ translate('Shop Anytime') }}</h1>
      </div>
      <div class="col-md-4 footer-apps-content">
        <p>{{ translate('Download the City Lulu app') }}</p>
        <p>{{ translate('Enjoy the best offers') }}</p>
        <img src="{{ static_asset('citylolo/images/googleplay.png') }}" alt="">
        <img src="{{ static_asset('citylolo/images/appstore.png') }}" alt="">
      </div>
      <div class="col-md-4 footer-apps-content">
        <div class="footer-icons">
          <div class="row">
              
              
              
                   
                    
                 {{--   @if ( get_setting('youtube_link') !=  null )
                    
                        <a href="{{ get_setting('youtube_link') }}" target="_blank" class="youtube"><i class="lab la-youtube"></i></a>
                   
                    @endif --}}
                   
              
              
              
              
              
              
            <a href="#" target="_blank"><i class="fab fa-whatsapp"></i></a>
            <a href="#" target="_blank"><i class="fab fa-snapchat"></i></a>
             @if ( get_setting('linkedin_link') !=  null )
                    
                        <a href="{{ get_setting('linkedin_link') }}" target="_blank"><i class="lab la-linkedin-in"></i></a>
                    
                    @endif
            @if ( get_setting('instagram_link') !=  null )
                    
                        <a href="{{ get_setting('instagram_link') }}" target="_blank"><i class="lab la-instagram"></i></a>
                   
                    @endif
            @if ( get_setting('facebook_link') !=  null )
                    
                        <a href="{{ get_setting('facebook_link') }}" target="_blank"><i class="lab la-facebook-f"></i></a>
                   
                    @endif
             @if ( get_setting('twitter_link') !=  null )
                    
                        <a href="{{ get_setting('twitter_link') }}" target="_blank"><i class="lab la-twitter"></i></a>
                   
                    @endif
          </div>
        </div>
        <p>{{ translate('Follow us on social media') }}</p>
      </div>
    </div>
  </div>
  
  <div class="col-md-12 footer-apps text-center">
    <div class="row">
      <ul>
        <a href="#">
          <li>{{ translate('Employment Opportunities') }}</li>
        </a>
        <a href="{{ route('shops.create') }}">
          <li>{{ translate('Be a Seller') }}</li>
        </a>
        <a href="{{ route('terms') }}">
          <li>{{ translate('Terms & conditions') }}</li>
        </a>
        <a href="{{ route('returnpolicy') }}">
          <li>{{ translate('Return Policy') }}</li>
        </a>
        <a href="{{ route('supportpolicy') }}">
          <li>{{ translate('Support Policy') }}</li>
        </a>
        <a href="{{ route('privacypolicy') }}">
          <li>{{ translate('Privacy Policy') }}</li>
        </a>
        <a href="#">
          <li>{{ translate('Consumer rights') }}</li>
        </a>
      </ul>
    </div>
  </div>
  <div class="col-12 footer-apps text-center">
    <div class="row">
      <ul>
        <li>{{ translate('All Right Recived') }}</li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li>
        <div class="col-lg-4">
                <div class="text-center text-md-right">
                    <ul>
                        @if ( get_setting('payment_method_images') !=  null )
                            @foreach (explode(',', get_setting('payment_method_images')) as $key => $value)
                                <li>
                                    <img src="{{ uploaded_asset($value) }}" style="max-height: 25px;">
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li>{{ translate('Developed by') }} <a href="https://loop-pr.com" target="_blank"><img src="{{ static_asset('citylolo/images/loop.png') }}" style="max-height: 50px;"></a></li>
      </ul>
    </div>
  </div>

</footer>
</div><!-- site / end -->




<!-- mobilemenu -->
<div class="mobilemenu">
  <div class="mobilemenu__backdrop"></div>
  <div class="mobilemenu__body">
    <div class="mobilemenu__header">
      <div class="mobilemenu__title">الأقسام</div><button type="button" class="mobilemenu__close"><svg width="20px" height="20px">
          <use xlink:href="{{ static_asset('citylolo/images/sprite.svg#cross-20') }}"></use>
        </svg></button>
    </div>
    <div class="mobilemenu__content">
      <ul class="mobile-links mobile-links--level--0" data-collapse data-collapse-opened-class="mobile-links__item--open">
        @foreach (\App\Category::where('level', 0)->orderBy('order_level', 'desc')->get()->take(11) as $category)
          <li class="mobile-links__item" data-collapse-item>
            <div class="mobile-links__item-title"><a href="{{ route('products.category', $category->slug) }}" class="mobile-links__item-link">{{ $category->getTranslation('name') }}</a> <button class="mobile-links__item-toggle" type="button" data-collapse-trigger><svg class="mobile-links__item-arrow" width="12px" height="7px">
                  <use xlink:href="{{ static_asset('citylolo/images/sprite.svg#arrow-rounded-down-12x7') }}"></use>
                </svg></button></div>
            <div class="mobile-links__item-sub-links" data-collapse-content>
              <ul class="mobile-links mobile-links--level--1">
                @foreach (\App\Category::where('parent_id', $category->id)->orderBy('order_level', 'desc')->get()->take(11)  as  $cate)
                  @if ($cate->parent_id == $category->id)
                  <li class="mobile-links__item" data-collapse-item>
                    <div class="mobile-links__item-title"><a href="{{ url('category') }}/{{ $cate->slug }}" class="mobile-links__item-link">{{ $cate->getTranslation('name') }}</a> <button class="mobile-links__item-toggle" type="button" data-collapse-trigger><svg class="mobile-links__item-arrow" width="12px" height="7px">
                          <use xlink:href="{{ static_asset('citylolo/images/sprite.svg#arrow-rounded-down-12x7') }}"></use>
                        </svg></button></div>
                    <div class="mobile-links__item-sub-links" data-collapse-content>
                      <ul class="mobile-links mobile-links--level--2">
                        @foreach (\App\Category::where('parent_id', $cate->id)->orderBy('order_level', 'desc')->get()->take(11)  as  $cate)
                          <li class="mobile-links__item" data-collapse-item>
                            <div class="mobile-links__item-title"><a href="{{ url('category') }}/{{ $cate->slug }}" class="mobile-links__item-link">{{ $cate->getTranslation('name') }}</a></div>
                          </li>
                         @endforeach
                      </ul>
                    </div>
                  </li>
                  @endif
                 @endforeach
              </ul>
            </div>
          </li>
         @endforeach
      </ul>
    </div>
  </div>
</div>
<!-- mobilemenu / end -->

