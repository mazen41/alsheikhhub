<a href="{{ route('wishlists.index') }}" class="d-flex align-items-center text-reset">
    <i class="la la-heart-o la-2x opacity-100 cart_compaire_wishlist"></i>
    {{-- <svg width="20px" height="20px">
      <use xlink:href="{{ static_asset('citylolo/images/sprite.svg#heart-20') }}"></use>
    </svg> --}}
    <span class="flex-grow-1 ml-1">
        @if(Auth::check())
            <span class="badge badge-primary badge-inline badge-pill">{{ count(Auth::user()->wishlists)}}</span>
        @else
            {{-- <span class="badge badge-primary badge-inline badge-pill">0</span> --}}
            <span id="wish-item" class="indicator__valueb adge badge-primary badge-inline badge-pill">0</span>
        @endif
        {{-- <span class="nav-box-text d-none d-xl-block opacity-70">{{translate('Wishlist')}}</span> --}}
        <div class="indicator"><a href="wishlist.html" class="indicator__button"><span class="indicator__area">
          
    </span>
</a>
