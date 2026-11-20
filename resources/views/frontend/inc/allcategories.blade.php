<div class="nav-panel__departments">
  <!-- .departments -->
  <div class="departments" data-departments-fixed-by="" style="width: 225px;">
    <div class="departments__body" style="background:rgb(184, 42, 42);padding: 27px;margin: -6px;">
      <div class="departments__links-wrapper">
        <div class="departments__submenus-container"></div>
        <ul class="departments__links" style="padding-top: 20px;">
          {{-- main categories --}}
           @foreach (\App\Category::where('level', 0)->orderBy('order_level', 'desc')->get()->take(11) as $category)
          <li class="departments__item"><a class="departments__item-link" href="{{ route('products.category', $category->slug) }}">{{ $category->getTranslation('name') }} <svg
                class="departments__item-arrow" width="6px" height="9px">
                <use xlink:href="{{ static_asset('citylolo/images/sprite.svg#arrow-rounded-right-6x9') }}"></use>
              </svg></a>
            <div class="departments__submenu departments__submenu--type--megamenu departments__submenu--size--xl">
            {{-- <div class="nav-links__submenu nav-links__submenu--type--megamenu nav-links__submenu--size--xl"> --}}
              <!-- .megamenu -->
              <div class="megamenu megamenu--departments">
                <div class="megamenu__body"
                  style="background-image: url('{{ static_asset('citylolo/images/megamenu/megamenu-1.jpg') }}');">
                  <div class="row">
                      {{-- subcategories --}}
                      @foreach (\App\Category::where('parent_id', $category->id)->orderBy('order_level', 'desc')->get()->take(11)  as  $cate)
                        @if ($cate->parent_id == $category->id)
                        <div class="col-4">
                          <ul class="megamenu__links megamenu__links--level--0">
                            <li class="megamenu__item megamenu__item--with-submenu"><a href="{{ url('category') }}/{{ $cate->slug }}">{{ $cate->getTranslation('name') }}</a>
                              <ul class="megamenu__links megamenu__links--level--1">
                                {{-- subsubcategories --}}
                                @foreach (\App\Category::where('parent_id', $cate->id)->orderBy('order_level', 'desc')->get()->take(11)  as  $cate)
                                <li class="megamenu__item"><a href="{{ url('category') }}/{{ $cate->slug }}">{{ $cate->getTranslation('name') }}</a></li>
                                @endforeach

                              </ul>
                            </li>
                          </ul>
                        </div>
                        @endif
                      @endforeach
                  </div>
                </div>
              </div><!-- .megamenu / end -->
            </div>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
    
    <button class="departments__button" style="font-family: 'Tajawal';font-weight: bolder;"><svg class="departments__button-icon" width="18px"
        height="14px">
        <use xlink:href="{{ static_asset('citylolo/images/sprite.svg#menu-18x14') }}"></use>
      </svg> {{ translate('All Categories') }} <svg class="departments__button-arrow" width="9px" height="6px">
        <use xlink:href="{{ static_asset('citylolo/images/sprite.svg#arrow-rounded-down-9x6') }}"></use>
      </svg>
    </button>
  </div><!-- .departments / end -->
</div><!-- .nav-links -->