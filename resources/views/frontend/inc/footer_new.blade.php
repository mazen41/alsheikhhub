</div>

<footer class="footer">
    @if (get_setting('home_banner6_images') != null)
        @php $banner_6_imags = json_decode(get_setting('home_banner6_images')); @endphp
        @foreach ($banner_6_imags as $key => $value)
            <div class="mb-5">
                <a href="{{ json_decode(get_setting('home_banner6_links'), true)[$key] }}" class="d-block text-reset text-center">
                    <img src="{{ static_asset('assets/img/no-image-rect.svg') }}" data-src="{{ uploaded_asset($banner_6_imags[$key]) }}" alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload">
                </a>
            </div>
        @endforeach
    @endif

    <div class="col-12 footer-apps text-center py-5 px-0">
        <div class="row align-content-center align-items-center d-flex justify-content-center">
            <div class="col-md-4 footer-apps-content">
                <h1 class="mb-0">{{ translate('Shop Anytime') }}</h1>
            </div>
            <div class="col-md-4 footer-apps-content">
                <p class="mb-0">{{ translate('Download the City Lulu app') }}</p>
                <p class="mb-4">{{ translate('Enjoy the best offers') }}</p>
                <img src="{{ static_asset('citylolo/images/googleplay.png') }}" alt="">
                <img src="{{ static_asset('citylolo/images/appstore.png') }}" alt="">
            </div>
            <div class="col-md-4 footer-apps-content">
                <div class="footer-icons d-flex justify-content-center align-items-center align-content-center mb-2" style="width: auto;gap: 5px;">

                    {{--   @if ( get_setting('youtube_link') !=  null )

                           <a href="{{ get_setting('youtube_link') }}" target="_blank" class="youtube"><i class="lab la-youtube"></i></a>

                       @endif --}}


                    @php
                        $footerWhatsappValue = trim((string) (get_setting('whatsapp_link') ?: get_setting('contact_phone')));
                        $footerWhatsappHref = '';
                        if ($footerWhatsappValue !== '') {
                            $footerWhatsappHref = preg_match('/^https?:\/\//i', $footerWhatsappValue)
                                ? $footerWhatsappValue
                                : 'https://wa.me/'.preg_replace('/\D+/', '', $footerWhatsappValue);
                            if ($footerWhatsappHref !== 'https://wa.me/' && stripos($footerWhatsappHref, 'text=') === false) {
                                $footerWhatsappHref .= (strpos($footerWhatsappHref, '?') === false ? '?' : '&').'text='.rawurlencode('مرحبًا، أود التواصل مع المتجر.');
                            }
                        }
                    @endphp
                    @if ($footerWhatsappHref !== '' && $footerWhatsappHref !== 'https://wa.me/')
                        <a href="{{ $footerWhatsappHref }}" target="_blank" rel="noopener noreferrer" aria-label="{{ translate('Chat with us on WhatsApp') }}"><i class="fab fa-whatsapp"></i></a>
                    @endif
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
                <p>{{ translate('Follow us on social media') }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-12 footer-apps text-center" style="background-color: rgba(145,179,179, .21)">
            <ul class="d-flex align-content-center align-items-center d-flex  justify-content-center">
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
    <div class="col-12 footer-apps text-center p-0 fs-14">
            <div class="container">
                <ul class="d-flex align-content-center align-items-center d-flex  justify-content-between">
                <li>{{ translate('All Right Recived') }}</li>
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
                <li>{{ translate('Developed by') }}
                    <a href="https://loop-pr.com" target="_blank"><img src="{{ static_asset('citylolo/images/loop.png') }}" style="max-height: 50px;"></a>
                </li>
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
            <div class="mobilemenu__title">الأقسام</div>
            <button type="button" class="mobilemenu__close">
                <svg width="20px" height="20px">
                    <use xlink:href="{{ static_asset('citylolo/images/sprite.svg#cross-20') }}"></use>
                </svg>
            </button>
        </div>
        <div class="mobilemenu__content">
            <ul class="mobile-links mobile-links--level--0" data-collapse data-collapse-opened-class="mobile-links__item--open">
                @foreach (\App\Category::where('level', 0)->orderBy('order_level', 'desc')->get()->take(11) as $category)
                    <li class="mobile-links__item" data-collapse-item>
                        <div class="mobile-links__item-title">
                            <a href="{{ route('products.category', $category->slug) }}" class="mobile-links__item-link">{{ $category->getTranslation('name') }}</a>
                            <button class="mobile-links__item-toggle" type="button" data-collapse-trigger>
                                <svg class="mobile-links__item-arrow" width="12px" height="7px">
                                    <use xlink:href="{{ static_asset('citylolo/images/sprite.svg#arrow-rounded-down-12x7') }}"></use>
                                </svg>
                            </button>
                        </div>
                        <div class="mobile-links__item-sub-links" data-collapse-content>
                            <ul class="mobile-links mobile-links--level--1">
                                @foreach (\App\Category::where('parent_id', $category->id)->orderBy('order_level', 'desc')->get()->take(11)  as  $cate)
                                    @if ($cate->parent_id == $category->id)
                                        <li class="mobile-links__item" data-collapse-item>
                                            <div class="mobile-links__item-title">
                                                <a href="{{ url('category') }}/{{ $cate->slug }}" class="mobile-links__item-link">{{ $cate->getTranslation('name') }}</a>
                                                <button class="mobile-links__item-toggle" type="button" data-collapse-trigger>
                                                    <svg class="mobile-links__item-arrow" width="12px" height="7px">
                                                        <use xlink:href="{{ static_asset('citylolo/images/sprite.svg#arrow-rounded-down-12x7') }}"></use>
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="mobile-links__item-sub-links" data-collapse-content>
                                                <ul class="mobile-links mobile-links--level--2">
                                                    @foreach (\App\Category::where('parent_id', $cate->id)->orderBy('order_level', 'desc')->get()->take(11)  as  $cate)
                                                        <li class="mobile-links__item" data-collapse-item>
                                                            <div class="mobile-links__item-title">
                                                                <a href="{{ url('category') }}/{{ $cate->slug }}" class="mobile-links__item-link">{{ $cate->getTranslation('name') }}</a>
                                                            </div>
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

