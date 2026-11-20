{{-- <!-- Top Bar --> --}}
{{-- <div class="top-navbar bg-white border-bottom border-soft-secondary z-1035">
    <div class="container">
        <div class="row">

            <div class="col-lg-7 col">
                <ul class="list-inline d-flex justify-content-between justify-content-lg-start mb-0">
                    @if(get_setting('show_language_switcher') == 'on')
                    <li class="list-inline-item dropdown mr-3" id="lang-change">
                        @php
                            if(Session::has('locale')){
                                $locale = Session::get('locale', Config::get('app.locale'));
                            }
                            else{
                                $locale = 'en';
                            }
                        @endphp
                        <a href="javascript:void(0)" class="dropdown-toggle text-reset py-2" data-toggle="dropdown" data-display="static">
                            <img src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ static_asset('assets/img/flags/'.$locale.'.png') }}" class="mr-2 lazyload" alt="{{ \App\Language::where('code', $locale)->first()->name }}" height="11">
                            <span class="opacity-60">{{ \App\Language::where('code', $locale)->first()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-left">
                            @foreach (\App\Language::all() as $key => $language)
                                <li>
                                    <a href="javascript:void(0)" data-flag="{{ $language->code }}" class="dropdown-item @if($locale == $language) active @endif">
                                        <img src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ static_asset('assets/img/flags/'.$language->code.'.png') }}" class="mr-1 lazyload" alt="{{ $language->name }}" height="11">
                                        <span class="language">{{ $language->name }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    @endif

                    @if(get_setting('show_currency_switcher') == 'on')
                    <li class="list-inline-item dropdown" id="currency-change">
                        @php
                            if(Session::has('currency_code')){
                                $currency_code = Session::get('currency_code');
                            }
                            else{
                                $currency_code = \App\Currency::findOrFail(\App\BusinessSetting::where('type', 'system_default_currency')->first()->value)->code;
                            }
                        @endphp
                        <a href="javascript:void(0)" class="dropdown-toggle text-reset py-2 opacity-60" data-toggle="dropdown" data-display="static">
                            {{ \App\Currency::where('code', $currency_code)->first()->name }} {{ (\App\Currency::where('code', $currency_code)->first()->symbol) }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
                            @foreach (\App\Currency::where('status', 1)->get() as $key => $currency)
                                <li>
                                    <a class="dropdown-item @if($currency_code == $currency->code) active @endif" href="javascript:void(0)" data-currency="{{ $currency->code }}">{{ $currency->name }} ({{ $currency->symbol }})</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    @endif
                </ul>
            </div>

            <div class="col-5 text-right d-none d-lg-block">
                <ul class="list-inline mb-0">
                    @auth
                        @if(isAdmin())
                            <li class="list-inline-item mr-3">
                                <a href="{{ route('admin.dashboard') }}" class="text-reset py-2 d-inline-block opacity-60">{{ translate('My Panel')}}</a>
                            </li>
                        @else
                            <li class="list-inline-item mr-3">
                                <a href="{{ route('dashboard') }}" class="text-reset py-2 d-inline-block opacity-60">{{ translate('My Panel')}}</a>
                            </li>
                        @endif
                        <li class="list-inline-item">
                            <a href="{{ route('logout') }}" class="text-reset py-2 d-inline-block opacity-60">{{ translate('Logout')}}</a>
                        </li>
                    @else
                        <li class="list-inline-item mr-3">
                            <a href="{{ route('user.login') }}" class="text-reset py-2 d-inline-block opacity-60">{{ translate('Login')}}</a>
                        </li>
                        <li class="list-inline-item">
                            <a href="{{ route('user.registration') }}" class="text-reset py-2 d-inline-block opacity-60">{{ translate('Registration')}}</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </div>
</div> --}}
{{-- <!-- END Top Bar --> --}}





<header class="@if(get_setting('header_stikcy') == 'on') sticky-top @endif z-1020 bg-white border-bottom shadow-sm">
    {{-- header --}}
    {{-- <!-- desktop site__header --> --}}
    <div class="site-header">
        {{-- <!-- .topbar --> --}}
        {{-- @include('frontend.inc.topmenu') --}}
        {{-- header desktop --}}
        <header class="site__header d-lg-block d-none">
            @include('frontend.inc.topheader')

            {{-- <!-- .topbar / end --> --}}
            <div class="site-header__nav-panel">
                {{-- <!-- data-sticky-mode - one of [pullToShow, alwaysOnTop] --> --}}
                <div class="nav-panel nav-panel--sticky" data-sticky-mode="pullToShow">
                    <div class="nav-panel__container container-fluid">
                        <div class="nav-panel__row">

                            <div class="nav-panel__logo"><a href="#">
                                    {{-- <!-- logo --> --}}
                                    {{-- <!-- logo / end --> --}}
                                </a>
                            </div>

                            {{-- all categories --}}
                            @include('frontend.inc.allcategories')

                            {{-- nav success --}}
                            <div class="nav-panel__nav-links nav-links">
                                <ul class="nav-links__list">


                                    @foreach (\App\Category::where('level', 0)->orderBy('order_level', 'desc')->get()->take(7) as $category)

                                        <li class="nav-links__item nav-links__item--has-submenu"><a class="nav-links__item-link" href="{{ route('products.category', $category->slug) }}">
                                                <div class="nav-links__item-body" style="color:white;">{{ $category->getTranslation('name') }} <svg class="nav-links__item-arrow" width="9px" height="6px">
                                                        <use xlink:href="{{ static_asset('citylolo/images/sprite.svg#arrow-rounded-down-9x6') }}"></use>
                                                    </svg></div>
                                            </a>
                                            <div class="nav-links__submenu nav-links__submenu--type--megamenu nav-links__submenu--size--xl">
                                                {{-- <!-- .megamenu --> --}}
                                                <div class="megamenu">
                                                    <div class="megamenu__body">
                                                        <div class="row">

                                                            <div class="col-3">
                                                                <ul class="megamenu__links megamenu__links--level--0">
                                                                    <li class="megamenu__item megamenu__item--with-submenu"><a href="#">{{ translate('Categories')}}
                                                                        </a>
                                                                        <ul class="megamenu__links megamenu__links--level--1">
                                                                            @foreach (\App\Category::where('parent_id', $category->id)->orderBy('order_level', 'desc')->get()->take(7)  as  $cate)
                                                                                @if ($cate->parent_id == $category->id)
                                                                                    {{-- @if ($cate != null) --}}

                                                                                    <a href="{{ url('category') }}/{{ $cate->slug }}"><li class="megamenu__item megamenu_submenu" style="line-height: 2.6;">{{ $cate->getTranslation('name') }}
                                                                                            {{-- {{ $cate->parent_id }} = {{ $category->id }} --}}
                                                                                            <span class="menu_count">{{ \App\Product::where('category_id', $cate->id)->count() }}</span></li></a>

                                                                                    {{-- @endif --}}
                                                                                @endif
                                                                            @endforeach
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                            </div>

                                                            <div class="col-3">
                                                                {{ translate('Best Brands') }}

                                                                <div class="row">
                                                                    @foreach (\App\Brand::where('category_id', $category->id)->orWhere('category_parent_id', $category->id)->get()->take(6) as $brand)
                                                                        <a href="{{ route('products.brand', $brand->slug) }}"><img src="{{ uploaded_asset($brand->logo) }}" alt="{{ $brand->getTranslation('name') }}" class="h-100px w-140px" style="border: 1px solid lightgray;object-fit: cover;padding:5px;margin: 5px;"></a>
                                                                    @endforeach
                                                                </div>
                                                            </div>

                                                            <div class="col-6">
                                                                {{--  --}}
                                                                {{-- 3- offers --}}
                                                                @if (get_setting('home_banner5_images') != null)
                                                                    <div class="mb-4">
                                                                        <div class="container-fluid">
                                                                            <div class="row gutters-10">
                                                                                @php $banner_4_imags = json_decode(get_setting('home_banner5_images')); @endphp
                                                                                @foreach ($banner_4_imags as $key => $value)
                                                                                    @if (json_decode(get_setting('home_banner5_categories'), true)[$key] ==  $category->id)

                                                                                        <div class="col-xl col-md-6">
                                                                                            <div class="mb-3 mb-lg-0">
                                                                                                <a href="{{ json_decode(get_setting('home_banner5_links'), true)[$key] }}" class="d-block text-reset">
                                                                                                    <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ uploaded_asset($banner_4_imags[$key]) }}" alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload">
                                                                                                    {{-- {{ json_decode(get_setting('home_banner5_categories'), true)[$key] }}={{ $category_id }}-{{ $category->id }} --}}
                                                                                                </a>
                                                                                            </div>
                                                                                        </div>

                                                                                    @endif
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                {{--  --}}
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- <!-- .megamenu / end --> --}}
                                            </div>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                            {{-- end nav success --}}



                            <div class="nav-panel__indicators">
                                <div class="indicator indicator--trigger--click"><button type="button" class="indicator__button"><span class="indicator__area" style='display:none!important;'><svg class="indicator__icon" width="20px" height="20px" style='display:none!important;'>
                        <use xlink:href="{{ static_asset('citylolo/images/sprite.svg#search-20') }}"></use>
                      </svg> <svg class="indicator__icon indicator__icon--open" width="20px" height="20px">
                        <use xlink:href="{{ static_asset('citylolo/images/sprite.svg#cross-20') }}"></use>
                      </svg></span></button>
                                    <div class="indicator__dropdown">
                                        <div class="search search--location--indicator">
                                            <div class="search__body">
                                                <form class="search__form" action="#"><input class="search__input" name="search" placeholder="اكتب كلمة البحث" aria-label="Site search" type="text" autocomplete="off"> <button class="search__button search__button--type--submit" type="submit"><svg width="20px" height="20px">
                                                            <use xlink:href="{{ static_asset('citylolo/images/sprite.svg#search-20') }}"></use>
                                                        </svg></button>
                                                    <div class="search__border"></div>
                                                </form>
                                                <div class="search__suggestions suggestions suggestions--location--indicator"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-none d-lg-block ml-3 mr-0">
                                    <div class="" id="compare">
                                        @include('frontend.partials.compare')
                                    </div>
                                </div>
                                <div class="d-none d-lg-block ml-3 mr-0">
                                    <div class="" id="wishlist">
                                        @include('frontend.partials.wishlist')
                                    </div>
                                </div>
                                {{-- <div class="d-none d-lg-block  align-self-stretch ml-3 mr-0 " data-hover="dropdown" style='position: absolute;top: 0;'>
                                    <div class="nav-cart-box dropdown h-100" id="cart_items">
                                        @include('frontend.partials.cart')
                                    </div>
                                </div> --}}

                            </div>
                        </div>
                    </div>

                </div>
            </div>
    </div>
    </div>
</header>

{{-- end header --}}

{{-- mobile header --}}
<header class="site__header d-lg-none">
    @include('frontend.inc.mobile-topheader')
    <div class="mobile-header mobile-header--sticky" data-sticky-mode="pullToShow">
        <div class="mobile-header__panel">
            <div class="container">
                <div class="mobile-header__body">
                    <button class="mobile-header__menu-button">
                        <svg width="18px" height="14px">
                            <use xlink:href="{{ static_asset('citylolo/images/sprite.svg#menu-18x14') }}"></use>
                        </svg>
                    </button>
                    <a class="mobile-header__logo" href="home">
                        <!-- mobile-logo -->

                        <!-- mobile-logo / end -->
                    </a>
                    <div class="search search--location--mobile-header mobile-header__search">
                        <div class="search__body">
                            {{-- search --}}
                            <form action="{{ route('search') }}" method="GET" class="stop-propagation">
                                <div class="d-flex position-relative align-items-center">
                                    <div class="d-lg-none" data-toggle="class-toggle" data-target=".front-header-search">
                                        <button class="btn px-2" type="button"><i class="la la-2x la-long-arrow-left"></i></button>
                                    </div>
                                    <div class="input-group">
                                        <input type="text" class="border-0 border-lg form-control" id="search" name="q" placeholder="{{translate('I am shopping for...')}}" autocomplete="off">
                                        <div class="input-group-append d-none d-lg-block">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="la la-search la-flip-horizontal fs-18"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            {{-- end search --}}
                            {{-- <form class="search__form" action="#">
                              <input class="search__input" name="search" placeholder="اكتب كلمة البحث" aria-label="Site search" type="text" autocomplete="off">
                              <button class="search__button search__button--type--submit" type="submit">
                                <svg width="20px" height="20px">
                                  <use xlink:href="{{ static_asset('citylolo/images/sprite.svg#search-20') }}"></use>
                                </svg>
                              </button>
                              <button class="search__button search__button--type--close" type="button">
                                <svg width="20px" height="20px">
                                  <use xlink:href="{{ static_asset('citylolo/images/sprite.svg#cross-20') }}"></use>
                                </svg>
                              </button>
                              <div class="search__border"></div>
                            </form> --}}
                            <div class="search__suggestions suggestions suggestions--location--mobile-header"></div>
                        </div>
                    </div>

                    <div class="mobile-header__indicators">

                        {{-- nav links --}}
                        <div class="indicator indicator--mobile-search indicator--mobile d-md-none">
                            <button class="indicator__button">
                  <span class="indicator__area">
                    <svg width="20px" height="20px">
                      <use xlink:href="{{ static_asset('citylolo/images/sprite.svg#search-20') }}"></use>
                    </svg></span>
                            </button>
                        </div>

                        {{-- wishlist --}}
                        <div class="indicator indicator--mobile d-sm-flex d-none">
                            <a href="#" class="indicator__button">
                  <span class="indicator__area">


                    {{-- <span class="flex-grow-1 ml-1"> --}}
                      @if(Auth::check())
                          <span class="badge badge-primary badge-inline badge-pill">{{ count(Auth::user()->wishlists)}}</span>
                      @else
                          <svg width="20px" height="20px">
                          <use xlink:href="{{ static_asset('citylolo/images/sprite.svg#heart-20') }}"></use>
                        </svg>
                          <span id="wish-item" class="indicator__value">0</span>
                          {{-- <span class="badge badge-primary badge-inline badge-pill">0</span> --}}
                          {{-- <span id="wish-item" class="indicator__valueb adge badge-primary badge-inline badge-pill">0</span> --}}
                      @endif
                      {{-- <span class="nav-box-text d-none d-xl-block opacity-70">{{translate('Wishlist')}}</span> --}}
                        <div class="indicator"><a href="#" class="indicator__button"><span class="indicator__area">

                    </span>
                    {{-- <div class="" id="wishlist">
                        @include('frontend.partials.wishlist')
                    </div> --}}
                  </span>
                            </a>
                        </div>

                        {{-- cart --}}
                        <div class="indicator indicator--mobile">
                            <a href="#" class="indicator__button">
                  <span class="indicator__area">
                    {{-- <svg width="20px" height="20px">
                      <use xlink:href="{{ static_asset('citylolo/images/sprite.svg#cart-20') }}"></use>
                    </svg> --}}
                      {{-- <span class=" cart-item indicator__value">0</span> --}}
                    <div class="nav-cart-box dropdown h-100" id="cart_items">
                      @include('frontend.partials.cart')
                    </div>
                  </span>
                            </a>
                        </div>


                    </div>

                    {{-- <div class="indicator indicator--trigger--click"><a href="#" class="indicator__button"><span class="indicator__area"><svg width="20px" height="20px">
                            <use xlink:href="{{ static_asset('citylolo/images/sprite.svg#person-20') }}"></use>
                          </svg></span></a>
                      <div class="indicator__dropdown">
                        <div class="account-menu">
                          @if(1===1)
                            <form class="account-menu__form">
                              <div class="account-menu__form-title">دخول</div>
                              <div class="form-group"><label for="header-signin-email" class="sr-only">البريد الإلكتروني</label> <input id="header-signin-email" type="email" class="form-control form-control-sm" placeholder="البريد الإلكتروني"></div>
                              <div class="form-group"><label for="header-signin-password" class="sr-only">كلمة المرور</label>
                                <div class="account-menu__form-forgot"><input id="header-signin-password" type="password" class="form-control form-control-sm" placeholder="كلمة المرور"> <a href="#" class="account-menu__form-forgot-link">نسيت؟</a></div>
                              </div>
                              <div class="form-group account-menu__form-button"><button type="submit" class="btn btn-primary btn-sm">دخول</button></div>
                              <div class="account-menu__form-link"><a href="account-login.html">إنشاء حساب</a></div>
                            </form>
                          @else
                            <div class="account-menu__divider"></div><a href="account-dashboard.html" class="account-menu__user">
                              <div class="account-menu__user-avatar"><img src="media/imgs/users/avatar.jpg" alt=""></div>
                              <div class="account-menu__user-info">
                                <div class="account-menu__user-name">الاسم</div>
                                <div class="account-menu__user-email">mail@mail.com</div>
                              </div>
                            </a>
                            <div class="account-menu__divider"></div>
                            <ul class="account-menu__links">
                              <li><a href="account-profile.html">ملفي الشخصي</a></li>
                              <li><a href="account-orders.html">طلباتي</a></li>
                              <li><a href="account-addresses.html">عناويني</a></li>
                              <li><a href="account-password.html">الاعدادات</a></li>
                            </ul>
                            <div class="account-menu__divider"></div>
                            <ul class="account-menu__links">
                              <li><a href="account-login.html">خروج</a></li>
                            </ul>
                          @endif
                        </div>
                      </div>
                    </div> --}}

                </div>
            </div>
        </div>
    </div>
</header>
{{-- end mobile header --}}
{{-- end new nav --}}
{{-- <div class="position-relative logo-bar-area z-1"> --}}
{{-- <div class="container"> --}}
{{-- <div class="d-flex align-items-center"> --}}

{{-- <div class="col-auto col-xl-3 pl-0 pr-3 d-flex align-items-center"> --}}
{{-- <a class="d-block py-20px mr-3 ml-0" href="{{ route('home') }}">
    @php
        $header_logo = get_setting('header_logo');
    @endphp
    @if($header_logo != null)
        <img src="{{ uploaded_asset($header_logo) }}" alt="{{ env('APP_NAME') }}" class="mw-100 h-30px h-md-40px" height="40">
    @else
        <img src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}" class="mw-100 h-30px h-md-40px" height="40">
    @endif
</a> --}}

{{-- @if(Route::currentRouteName() != 'home')
    <div class="d-none d-xl-block align-self-stretch category-menu-icon-box ml-auto mr-0">
        <div class="h-100 d-flex align-items-center" id="category-menu-icon">
            <div class="dropdown-toggle navbar-light bg-light h-40px w-50px pl-2 rounded border c-pointer">
                <span class="navbar-toggler-icon"></span>
            </div>
        </div>
    </div>
@endif --}}
{{-- </div> --}}
{{-- <div class="d-lg-none ml-auto mr-0">
    <a class="p-2 d-block text-reset" href="javascript:void(0);" data-toggle="class-toggle" data-target=".front-header-search">
        <i class="las la-search la-flip-horizontal la-2x"></i>
    </a>
</div> --}}

{{-- <div class="flex-grow-1 front-header-search d-flex align-items-center bg-white">
    <div class="position-relative flex-grow-1">
        <form action="{{ route('search') }}" method="GET" class="stop-propagation">
            <div class="d-flex position-relative align-items-center">
                <div class="d-lg-none" data-toggle="class-toggle" data-target=".front-header-search">
                    <button class="btn px-2" type="button"><i class="la la-2x la-long-arrow-left"></i></button>
                </div>
                <div class="input-group">
                    <input type="text" class="border-0 border-lg form-control" id="search" name="q" placeholder="{{translate('I am shopping for...')}}" autocomplete="off">
                    <div class="input-group-append d-none d-lg-block">
                        <button class="btn btn-primary" type="submit">
                            <i class="la la-search la-flip-horizontal fs-18"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <div class="typed-search-box stop-propagation document-click-d-none d-none bg-white rounded shadow-lg position-absolute left-0 top-100 w-100" style="min-height: 200px">
            <div class="search-preloader absolute-top-center">
                <div class="dot-loader"><div></div><div></div><div></div></div>
            </div>
            <div class="search-nothing d-none p-3 text-center fs-16">

            </div>
            <div id="search-content" class="text-left">

            </div>
        </div>
    </div>
</div> --}}

{{-- <div class="d-none d-lg-none ml-3 mr-0">
    <div class="nav-search-box">
        <a href="#" class="nav-box-link">
            <i class="la la-search la-flip-horizontal d-inline-block nav-box-icon"></i>
        </a>
    </div>
</div> --}}

{{-- <div class="d-none d-lg-block ml-3 mr-0">
    <div class="" id="compare">
        @include('frontend.partials.compare')
    </div>
</div>

<div class="d-none d-lg-block ml-3 mr-0">
    <div class="" id="wishlist">
        @include('frontend.partials.wishlist')
    </div>
</div>

<div class="d-none d-lg-block  align-self-stretch ml-3 mr-0" data-hover="dropdown">
    <div class="nav-cart-box dropdown h-100" id="cart_items">
        @include('frontend.partials.cart')
    </div>
</div> --}}

{{-- </div> --}}
{{-- </div> --}}
{{-- @if(Route::currentRouteName() != 'home')
<div class="hover-category-menu position-absolute w-100 top-100 left-0 right-0 d-none z-3" id="hover-category-menu">
    <div class="container">
        <div class="row gutters-10 position-relative">
            <div class="col-lg-3 position-static">
                @include('frontend.partials.category_menu')
            </div>
        </div>
    </div>
</div>
@endif --}}
{{-- </div> --}}
{{-- nav menu important --}}
{{-- @if ( get_setting('header_menu_labels') !=  null )
    <div class="bg-white border-top border-gray-200 py-1">
        <div class="container">
            <ul class="list-inline mb-0 pl-0 mobile-hor-swipe text-center">
                @foreach (json_decode( get_setting('header_menu_labels'), true) as $key => $value)
                <li class="list-inline-item mr-0">
                    <a href="{{ json_decode( get_setting('header_menu_links'), true)[$key] }}" class="opacity-60 fs-14 px-3 py-2 d-inline-block fw-600 hov-opacity-100 text-reset">
                        {{ translate($value) }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif --}}
<div class="site__body" style="min-height: 800px;">
