<header class="container-fluid">
  <div class="col-12 header">
    <div class="row">
      <div class="header-center col-2">
        <div class="logo">
          @php $headerLogo = get_setting('header_logo'); @endphp
          <a href="{{ route('home') }}">
            @if ($headerLogo)
              <img src="{{ uploaded_asset($headerLogo) }}" alt="{{ get_setting('website_name') ?: env('APP_NAME') }}" style="width:70px!important">
            @else
              <img src="{{ static_asset('assets/img/logo.png') }}" alt="{{ get_setting('website_name') ?: env('APP_NAME') }}" style="width:70px!important">
            @endif
          </a>
        </div>
      </div>
      <div class="header-left text-center col-10">
        <div class="row" style="padding-top:10px;">
          <div class="col-md-3">
              <form action="{{ route('search') }}" method="GET" class="stop-propagation">
                    <div class="d-flex position-relative align-items-center">
                        <div class="d-lg-none" data-toggle="class-toggle" data-target=".front-header-search">
                            <button class="btn px-2" type="button"><i class="la la-2x la-long-arrow-left"></i></button>
                        </div>
                        <div class="input-group">
                            <input type="text" class="border-0 border-lg form-control search-input-text" id="search" name="q" placeholder="{{translate('I am shopping for...')}}" autocomplete="off">
                            <div class="input-group-append d-none d-lg-block">
                                <button class="btn btn-primary search-input-button" type="submit">
                                    <i class="la la-search la-flip-horizontal fs-18"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
          </div>
          <div class="col-md-3 header-border text-center">
            <div class="btn-group">
                {{-- added by zuhair start--}}
                <button type="button" class="btn btn-light">
                  <img src="{{ static_asset('assets/img/flags/sa.png') }}" width="30" alt="">&nbsp;&nbsp;{{ translate('Delivery to Saudi Arabia') }}</button>
                {{-- added by zuhair end--}}
                {{-- by zuhair
                <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                  <img src="{{ static_asset('assets/img/flags/sa.png') }}" width="30" alt="">&nbsp;&nbsp;{{ translate('Delivery to Saudi Arabia') }}</button>
                <div class="dropdown-menu dropdown-menu-lg-right">
                  <a href="https://uae.citylolo.com"><button class="dropdown-item" type="button"><img src="{{ static_asset('assets/img/flags/ae.png') }}" width="30" alt="">&nbsp;&nbsp;{{ translate('Delivery to UAE') }}</button></a>
                  <a href="https://yemen.citylolo.com"><button class="dropdown-item" type="button"><img src="{{ static_asset('assets/img/flags/ye.png') }}" width="30" alt="">&nbsp;&nbsp;{{ translate('Delivery to Yemen') }}</button></a>
                </div>
                --}}
              </div>
          </div>
          
          <div class="col-md-1 header-borders text-right" style="padding: 0!important;">
            <div class="">
                <ul class="list-inline d-flex justify-content-between justify-content-lg-start mb-0">
                    @if(get_setting('show_language_switcher') == 'on')
                    <li class="list-inline-item dropdown mr-3" style="padding: 0!important;margin: 0!important;" id="lang-change">
                        @php
                            if(Session::has('locale')){
                                $locale = Session::get('locale', Config::get('app.locale'));
                            }
                            else{
                                $locale = 'en';
                            }
                        @endphp
                        <a href="javascript:void(0)" class="dropdown-toggle text-reset py-2" data-toggle="dropdown" data-display="static">
                            <span class="opacity-100">{{ \App\Language::where('code', $locale)->first()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-left" >
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
                        <a href="javascript:void(0)" class="dropdown-toggle text-reset py-2 opacity-100" data-toggle="dropdown" data-display="static">
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
          </div>
          <div class="col-md-2 header-borders text-right" style="padding: 0;">
             {{-- <div class="d-none d-lg-block ml-3 mr-0">
                <div class="" id="compare">
                    @include('frontend.partials.compare')
                </div>
            </div> --}}

            {{-- <div class="d-none d-lg-block ml-3 mr-0">
                <div class="" id="wishlist">
                    @include('frontend.partials.wishlist')
                </div>
            </div> --}}

            <div class="d-none d-lg-block  align-self-stretch ml-3 mr-0" style="margin-right:0px!important;" data-hover="dropdown">
                <div class="nav-cart-box dropdown h-100" id="cart_items"> 
                    @include('frontend.partials.cart')
                </div>
            </div>

          </div>
          <div class="col-md-3 header-borders">
            <div class="">
                <ul class="list-inline mb-0">
                    @auth
                        @if(isAdmin())
                            <li class="list-inline-item mr-3">
                                <a href="{{ route('admin.dashboard') }}" class="text-reset py-2 d-inline-block opacity-100"><i class="fa fa-user-circle"></i> {{ translate('My Panel')}} </a>
                            </li>
                        @else

                            {{-- user menu --}}
                            <li class="list-inline-item mr-3">
                                <a href="javascript:void(0)" class="dropdown-toggle text-reset py-2" data-toggle="dropdown" data-display="static">
                                    <span class="opacity-100">{{Auth::user()->name}}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-left" style="padding-right: 5px;">
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('dashboard') }}" class="aiz-side-nav-link {{ areActiveRoutes(['dashboard'])}}">
                                            <i class="las la-home aiz-side-nav-icon"></i>
                                            <span class="aiz-side-nav-text" style="font-size: 80%;color: black;">{{ translate('Dashboard') }}</span>
                                        </a>
                                    </li>
                    
                                    @php
                                        $delivery_viewed = App\Order::where('user_id', Auth::user()->id)->where('delivery_viewed', 0)->get()->count();
                                        $payment_status_viewed = App\Order::where('user_id', Auth::user()->id)->where('payment_status_viewed', 0)->get()->count();
                                    @endphp
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('purchase_history.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['purchase_history.index'])}}">
                                            <i class="las la-file-alt aiz-side-nav-icon"></i>
                                            <span class="aiz-side-nav-text" style="font-size: 80%;color: black;">{{ translate('Purchase History') }}</span>
                                            @if($delivery_viewed > 0 || $payment_status_viewed > 0)<span class="badge badge-inline badge-success">{{ translate('New') }}</span>@endif
                                        </a>
                                    </li>
                    
                                    {{-- <li class="aiz-side-nav-item">
                                        <a href="{{ route('digital_purchase_history.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['digital_purchase_history.index'])}}">
                                            <i class="las la-download aiz-side-nav-icon"></i>
                                            <span class="aiz-side-nav-text" style="font-size: 80%;color: black;">{{ translate('Downloads') }}</span>
                                        </a>
                                    </li>--}}
                    
                                    @php
                                        $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();
                                        $club_point_addon = \App\Addon::where('unique_identifier', 'club_point')->first();
                                    @endphp
                                    @if ($refund_request_addon != null && $refund_request_addon->activated == 1)
                                        {{-- <li class="aiz-side-nav-item">
                                            <a href="{{ route('customer_refund_request') }}" class="aiz-side-nav-link {{ areActiveRoutes(['customer_refund_request'])}}">
                                                <i class="las la-backward aiz-side-nav-icon"></i>
                                                <span class="aiz-side-nav-text" style="font-size: 80%;color: black;">{{ translate('Sent Refund Request') }}</span>
                                            </a>
                                        </li>--}}
                                    @endif
                    
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('wishlists.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['wishlists.index'])}}">
                                            <i class="la la-heart-o aiz-side-nav-icon"></i>
                                            <span class="aiz-side-nav-text" style="font-size: 80%;color: black;">{{ translate('Wishlist') }}</span>
                                        </a>
                                    </li>
                    
                                    @if(Auth::user()->user_type == 'seller')
                                        <li class="aiz-side-nav-item">
                                            <a href="{{ route('seller.products') }}" class="aiz-side-nav-link {{ areActiveRoutes(['seller.products', 'seller.products.upload', 'seller.products.edit'])}}">
                                                <i class="lab la-sketch aiz-side-nav-icon"></i>
                                                <span class="aiz-side-nav-text" style="font-size: 80%;color: black;">{{ translate('Products') }}</span>
                                            </a>
                                        </li>
                                        {{-- <li class="aiz-side-nav-item">
                                            <a href="{{route('product_bulk_upload.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['product_bulk_upload.index'])}}">
                                                <i class="las la-upload aiz-side-nav-icon"></i>
                                                <span class="aiz-side-nav-text" style="font-size: 80%;color: black;">{{ translate('Product Bulk Upload') }}</span>
                                            </a>
                                        </li>
                                        <li class="aiz-side-nav-item">
                                            <a href="{{ route('seller.digitalproducts') }}" class="aiz-side-nav-link {{ areActiveRoutes(['seller.digitalproducts', 'seller.digitalproducts.upload', 'seller.digitalproducts.edit'])}}">
                                                <i class="lab la-sketch aiz-side-nav-icon"></i>
                                                <span class="aiz-side-nav-text" style="font-size: 80%;color: black;">{{ translate('Digital Products') }}</span>
                                            </a>
                                        </li>--}}
                                    @endif
                    
                                    @if(\App\BusinessSetting::where('type', 'classified_product')->first()->value == 1)
                                        {{-- <li class="aiz-side-nav-item">
                                            <a href="{{ route('customer_products.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['customer_products.index', 'customer_products.create', 'customer_products.edit'])}}">
                                                <i class="lab la-sketch aiz-side-nav-icon"></i>
                                                <span class="aiz-side-nav-text" style="font-size: 80%;color: black;">{{ translate('Classified Products') }}</span>
                                            </a>
                                        </li>--}}
                                    @endif
                    
                                    @if(Auth::user()->user_type == 'seller')
                                        @if (\App\Addon::where('unique_identifier', 'pos_system')->first() != null && \App\Addon::where('unique_identifier', 'pos_system')->first()->activated)
                                            @if (\App\BusinessSetting::where('type', 'pos_activation_for_seller')->first() != null && \App\BusinessSetting::where('type', 'pos_activation_for_seller')->first()->value != 0)
                                               {{-- <li class="aiz-side-nav-item">
                                                    <a href="{{ route('poin-of-sales.seller_index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['poin-of-sales.seller_index'])}}">
                                                        <i class="las la-fax aiz-side-nav-icon"></i>
                                                        <span class="aiz-side-nav-text" style="font-size: 80%;color: black;">{{ translate('POS Manager') }}</span>
                                                    </a>
                                                </li>--}}
                                            @endif
                                        @endif
                    
                                        @php
                                            $orders = DB::table('orders')
                                                        ->orderBy('code', 'desc')
                                                        ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                                                        ->where('order_details.seller_id', Auth::user()->id)
                                                        ->where('orders.viewed', 0)
                                                        ->select('orders.id')
                                                        ->distinct()
                                                        ->count();
                                        @endphp
                                        <li class="aiz-side-nav-item">
                                            <a href="{{ route('orders.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['orders.index'])}}">
                                                <i class="las la-money-bill aiz-side-nav-icon"></i>
                                                <span class="aiz-side-nav-text" style="font-size: 80%;color: black;">{{ translate('Orders') }}</span>
                                                @if($orders > 0)<span class="badge badge-inline badge-success">{{ $orders }}</span>@endif
                                            </a>
                                        </li>
                    
                                      
                                      
                                        
                    
                                        
                    
                                    @endif
                    
                                   
                    
                                    @if (\App\BusinessSetting::where('type', 'wallet_system')->first()->value == 1)
                                        <li class="aiz-side-nav-item">
                                            <a href="{{ route('wallet.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['wallet.index'])}}">
                                                <i class="las la-dollar-sign aiz-side-nav-icon"></i>
                                                <span class="aiz-side-nav-text" style="font-size: 80%;color: black;">{{translate('My Wallet')}}</span>
                                            </a>
                                        </li>
                                    @endif
                    
                                    @if ($club_point_addon != null && $club_point_addon->activated == 1)
                                        <li class="aiz-side-nav-item">
                                            <a href="{{ route('earnng_point_for_user') }}" class="aiz-side-nav-link {{ areActiveRoutes(['earnng_point_for_user'])}}">
                                                <i class="las la-dollar-sign aiz-side-nav-icon"></i>
                                                <span class="aiz-side-nav-text" style="font-size: 80%;color: black;">{{translate('Earning Points')}}</span>
                                            </a>
                                        </li>
                                    @endif
                    
                                    
                    
                                    @php
                                        $support_ticket = DB::table('tickets')
                                                    ->where('client_viewed', 0)
                                                    ->where('user_id', Auth::user()->id)
                                                    ->count();
                                    @endphp
                    
                                   
                    
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('profile') }}" class="aiz-side-nav-link {{ areActiveRoutes(['profile'])}}">
                                            <i class="las la-user aiz-side-nav-icon"></i>
                                            <span class="aiz-side-nav-text" style="font-size: 80%;color: black;">{{translate('Manage Profile')}}</span>
                                        </a>
                                    </li>
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('logout') }}" class="aiz-side-nav-link {{ areActiveRoutes(['profile'])}}">
                                            <i class="las la-sign-out-alt aiz-side-nav-icon"></i>
                                            <span class="aiz-side-nav-text" style="font-size: 80%;color: black;">{{ translate('Logout')}}</span>
                                        </a>
                                    </li>
                                     
                                </ul>
                            </li>
                            {{-- user menu --}}
                                
                        @endif
                       
                    @else
                        <li class="list-inline-item mr-3">
                            <a href="{{ route('user.login') }}" class="text-reset py-2 d-inline-block opacity-100"><i class="fa fa-user"></i> {{ translate('Login')}}</a>
                        </li>
                        <li class="list-inline-item">
                            <a href="{{ route('user.registration') }}" class="text-reset py-2 d-inline-block opacity-100">{{ translate('Registration')}}</a>
                        </li>
                    @endauth
                </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
