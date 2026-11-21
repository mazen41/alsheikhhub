@php
    $configuredCategoryIds = json_decode(get_setting('home_categories') ?: '[]', true) ?: [];
    $homeCategories = collect($configuredCategoryIds)
        ->map(function ($id) { return \App\Category::find($id); })
        ->filter();

    if ($homeCategories->isEmpty()) {
        $homeCategories = \App\Category::where('parent_id', 0)
            ->orderBy('order_level', 'desc')
            ->get();
    }
@endphp

@foreach ($homeCategories as $category)
    @php
        $categoryIds = \App\Utility\CategoryUtility::children_ids($category->id);
        $categoryIds[] = $category->id;
        $categoryProducts = filter_products(
            \App\Product::where('published', 1)
                ->whereIn('category_id', $categoryIds)
                ->orderBy('created_at', 'desc')
        )->limit(12)->get();
        $categoryChildren = \App\Category::where('parent_id', $category->id)
            ->orderBy('order_level', 'desc')
            ->get();
        $categoryBanners = [];
        foreach ([4, 7] as $bannerSlot) {
            $bannerImages = json_decode(get_setting('home_banner'.$bannerSlot.'_images') ?: '[]', true) ?: [];
            $bannerCategories = json_decode(get_setting('home_banner'.$bannerSlot.'_categories') ?: '[]', true) ?: [];
            $bannerLinks = json_decode(get_setting('home_banner'.$bannerSlot.'_links') ?: '[]', true) ?: [];

            foreach ($bannerImages as $index => $imageId) {
                $imageUrl = uploaded_asset($imageId);
                if ((int) data_get($bannerCategories, $index, 0) === (int) $category->id && $imageUrl) {
                    $categoryBanners[] = [
                        'image' => $imageUrl,
                        'link' => data_get($bannerLinks, $index, '#'),
                    ];
                }
            }
        }
    @endphp

    @if ($categoryProducts->isNotEmpty())
        <section class="mb-4">
            <div class="container-fluid">
                <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                    <div class="d-flex flex-wrap mb-3 align-items-baseline border-bottom">
                        <h2 class="h5 fw-700 mb-0">
                            <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">
                                {{ $category->getTranslation('name') }}
                            </span>
                        </h2>
                        <a href="{{ route('products.category', $category->slug) }}" class="ml-auto mr-0 btn btn-primary btn-sm shadow-md">
                            {{ translate('View More') }}
                        </a>
                    </div>

                    @if ($categoryChildren->isNotEmpty())
                        <div class="d-flex flex-wrap mb-3" style="gap: 8px;">
                            @foreach ($categoryChildren as $child)
                                <a href="{{ route('products.category', $child->slug) }}" class="btn btn-sm btn-outline-secondary">
                                    {{ $child->getTranslation('name') }}
                                </a>
                            @endforeach
                        </div>
                    @endif

                    <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="5" data-lg-items="4" data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows="true" data-infinite="true">
                        @foreach ($categoryProducts as $product)
                            <div class="carousel-box">
                                @include('common.product_item', ['product' => $product])
                            </div>
                        @endforeach
                    </div>

                    @if (count($categoryBanners) > 0)
                        <div class="row gutters-10 mt-4">
                            @foreach ($categoryBanners as $banner)
                                <div class="col-12 mb-3">
                                    <a href="{{ $banner['link'] }}" class="d-block">
                                        <img src="{{ $banner['image'] }}" class="img-fluid w-100" alt="{{ $category->getTranslation('name') }}" onerror="this.onerror=null;this.closest('.col-12').remove();">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif
@endforeach
