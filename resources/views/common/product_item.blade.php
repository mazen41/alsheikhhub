<div class="aiz-card-box h-100 border border-light rounded shadow-sm hov-shadow-md has-transition bg-white  position-relative" style="padding-bottom: 36px;">
      <div class="position-relative">
          <a href="{{ route('product', $product->slug) }}" class="d-block">
              <img
                  class="img-fit lazyload mx-auto h-160px h-md-220px h-xl-270px h-xxl-250px"
                  src="{{ static_asset('assets/img/placeholder.jpg') }}"
                  data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                  alt="{{  $product->getTranslation('name')  }}"
                  onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
              >
          </a>
          <div class="absolute-top-right aiz-p-hov-icon">
              <a href="javascript:void(0)" onclick="addToWishList({{ $product->id }})" data-toggle="tooltip" data-title="{{ translate('Add to wishlist') }}" data-placement="left">
                  <i class="la la-heart-o"></i>
              </a>
              <a href="javascript:void(0)" onclick="addToCompare({{ $product->id }})" data-toggle="tooltip" data-title="{{ translate('Add to compare') }}" data-placement="left">
                  <i class="las la-sync"></i>
              </a>
              <a href="javascript:void(0)" onclick="showAddToCartModal({{ $product->id }})" data-toggle="tooltip" data-title="{{ translate('Add to cart') }}" data-placement="left">
                  <i class="las la-shopping-cart"></i>
              </a>
          </div>
      </div>
      
      <div class="p-md-3 p-2 text-left">
          
          {{-- title --}}
          <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0">
              <a href="{{ route('product', $product->slug) }}" class="d-block text-reset">{{ $product->getTranslation('name') }}</a>
          </h3>
        {{-- price --}}
          <div class="fs-15">
              
              <span class="fw-900 text-primary " style="font-size: 100%">{{ home_discounted_base_price($product->id) }}</span>
              @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                <div>
                  <del class="fw-400 opacity-50 mr-1" style="font-size: 80%">{{ home_base_price($product->id) }}</del>
                  </div>
              @endif

              @if(price_discount_percentage(home_base_price($product->id), home_discounted_base_price($product->id)))
              <span class="rounded-pill priceReductionPercentage position-absolute">
                {{price_discount_percentage(home_base_price($product->id), home_discounted_base_price($product->id))}}
              </span>
              @endif

          </div>

          {{-- rating --}}
          <div class="rating rating-sm mt-1">
              {{ renderStarRating($product->rating) }}
          </div>
        

          @if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Addon::where('unique_identifier', 'club_point')->first()->activated)
              <div class="rounded px-2 mt-2 bg-soft-primary border-soft-primary border">
                  {{ translate('Club Point') }}:
                  <span class="fw-700 float-right">{{ $product->earn_point }}</span>
              </div>
          @endif
      </div>
          <div class="lolo-express">
              <img src="{{static_asset('assets/img/lolo_express.png') }}" style="max-width: 100%;height:auto;" alt="Lolo express" />
          </div>
      
  </div>