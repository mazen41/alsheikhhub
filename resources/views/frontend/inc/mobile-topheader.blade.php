<header class="container-fluid px-0">
  <div class="col-12 header">
    <div class="row" style="background-color:white;">
      <div class="header-center col-3">
        <div class="logo">
          <a href="{{ route('home') }}"><img class="pt-10px" style="width:45px;" src="{{ static_asset('citylolo/images/logo.png') }}" alt="{{ env('APP_NAME') }}"></a>
        </div>
      </div>
      <div class="header-left text-center col-9">
        <div class="row">
          <div class="row">
         
          <div class="col-8 header-border text-left">
            <div class="btn-group">
                <button type="button" class="btn px-1 btn-light dropdown-toggle" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                  <img src="{{ static_asset('assets/img/flags/sa.png') }}" width="20em" alt="">&nbsp;&nbsp;التوصيل للسعودية</button>
                <div class="dropdown-menu dropdown-menu-lg-right">
                  <a href="https://uae.citylolo.com"><button class="dropdown-item" type="button"><img src="{{ static_asset('assets/img/flags/ae.png') }}" width="20em" alt="">&nbsp;&nbsp;التوصيل للإمارات</button></a>
                  <a href="https://yemen.citylolo.com"><button class="dropdown-item" type="button"><img src="{{ static_asset('assets/img/flags/ye.png') }}" width="20em" alt="">&nbsp;&nbsp;التوصيل لليمن</button></a>
                </div>
              </div>
               <div class="">
                <ul class="list-inline d-flex justify-content-between justify-content-lg-start mb-0">
                    @if(get_setting('show_language_switcher') == 'on')
                    <li class="list-inline-item dropdown mr-1" id="lang-change">
                        @php
                            if(Session::has('locale')){
                                $locale = Session::get('locale', Config::get('app.locale'));
                            }
                            else{
                                $locale = 'en';
                            }
                        @endphp
                        <a href="javascript:void(0)" class="dropdown-toggle text-reset py-0" data-toggle="dropdown" data-display="static">
                            <img src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ static_asset('assets/img/flags/'.$locale.'.png') }}" class="mr-0 lazyload" alt="{{ \App\Language::where('code', $locale)->first()->name }}" height="14">
                            <span class="opacity-60 px-2">{{ \App\Language::where('code', $locale)->first()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-left">
                            @foreach (\App\Language::all() as $key => $language)
                                <li>
                                    <a href="javascript:void(0)" data-flag="{{ $language->code }}" class="dropdown-item @if($locale == $language) active @endif">
                                        <img src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ static_asset('assets/img/flags/'.$language->code.'.png') }}" class="mr-1 lazyload" alt="{{ $language->name }}" height="14">
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
                        <a href="javascript:void(0)" class="dropdown-toggle text-reset py-0 opacity-60" data-toggle="dropdown" data-display="static">
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
          
          {{-- <div class="col-4 header-border text-right">
            <div class="">
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
                        <a href="javascript:void(0)" class="dropdown-toggle text-reset py-0" data-toggle="dropdown" data-display="static">
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
                        <a href="javascript:void(0)" class="dropdown-toggle text-reset py-0 opacity-60" data-toggle="dropdown" data-display="static">
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
          </div> --}}
         
          <div class="col-4 header-border">
            <div class="">
                <ul class="list-inline mb-0">
                    @auth
                        @if(isAdmin())
                            <li class="list-inline-item mr-3">
                                <a href="{{ route('admin.dashboard') }}" class="text-reset py-1 d-inline-block opacity-60"><i class="fa fa-user-circle"></i> {{ translate('My Panel')}}</a>
                            </li>
                        @else
                            <li class="list-inline-item mr-3">
                                <a href="{{ route('dashboard') }}" class="text-reset py-2 d-inline-block opacity-60"><i class="fa fa-user-circle"></i> <span style="font-family: 'citylololight';"> {{ translate('My Panel')}}</span></a>
                            </li>
                        @endif
                        <li class="list-inline-item">
                            <a href="{{ route('logout') }}" class="text-reset py-1 d-inline-block opacity-60">{{ translate('Logout')}}</a>
                        </li>
                    @else
                        <li class="list-inline-item mr-3">
                            <a href="{{ route('user.login') }}" class="text-reset py-1 d-inline-block opacity-60"><i class="fa fa-user"></i> {{ translate('Login')}}</a>
                        </li>
                        <li class="list-inline-item">
                            <a href="{{ route('user.registration') }}" class="text-reset py-0 d-inline-block opacity-60">{{ translate('Registration')}}</a>
                        </li>
                    @endauth
                </ul>
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>
</header>