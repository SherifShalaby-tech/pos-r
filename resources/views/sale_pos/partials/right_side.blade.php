<div class="d-flex flex-column">
    <div class="mb-1 d-flex flex-wrap" style="gap: 5px">
        @if (session('system_mode') != 'restaurant')

        <div class="card mb-0 px-0">
            <div class="card-body d-flex justify-content-between p-1" style="gap: 10px">
                <div class=" px-0 toggle-pill-color-pos d-flex justify-content-center align-items-center flex-column">
                    <input class="" type="checkbox" id="category-filter" />
                    <label class="checkbox-inline mb-0" for="category-filter">

                    </label>
                    <span class="toggle-pos-label">
                        @lang('lang.category')
                    </span>
                </div>

                <div class=" px-0 toggle-pill-color-pos d-flex justify-content-center align-items-center flex-column">
                    <input class="" type="checkbox" id="sub-category-filter" />
                    <label class="checkbox-inline mb-0" for="sub-category-filter">

                    </label>
                    <span class="toggle-pos-label">
                        @lang('lang.sub_category')
                    </span>
                </div>

                <div class=" px-0 toggle-pill-color-pos d-flex justify-content-center align-items-center flex-column">
                    <input class="" type="checkbox" id="brand-filter" />
                    <label class="checkbox-inline mb-0" for="brand-filter">
                    </label>
                    <span class="toggle-pos-label">
                        @lang('lang.brand')
                    </span>

                </div>
            </div>
        </div>


        <div class="card mb-0 px-0">
            <div class="card-body d-flex justify-content-between p-1" style="gap: 10px">

                <div class=" px-0 toggle-pill-color-pos d-flex justify-content-center align-items-center flex-column">
                    <input type="checkbox" class="selling_filter" id="best_selling" value="best_selling">
                    <label for="best_selling" class="checkbox-inline mb-0">

                    </label>
                    <span class="toggle-pos-label">
                        @lang('lang.best_selling')
                    </span>
                </div>
                <div class=" px-0 toggle-pill-color-pos d-flex justify-content-center align-items-center flex-column">
                    <input type="checkbox" class="selling_filter" id="product_in_last_transactions"
                        value="product_in_last_transactions">
                    <label for="product_in_last_transactions" class="checkbox-inline mb-0">
                    </label>
                    <span class="toggle-pos-label">
                        @lang('lang.product_in_last_transactions')
                    </span>
                </div>

                <div class=" px-0 toggle-pill-color-pos d-flex justify-content-center align-items-center flex-column">
                    <input type="checkbox" class="selling_filter" id="slow_moving_items" value="slow_moving_items">
                    <label for="slow_moving_items" class="checkbox-inline mb-0">
                    </label>
                    <span class="toggle-pos-label">
                        @lang('lang.slow_moving_items')
                    </span>
                </div>


            </div>
        </div>

        <div class="card mb-0 px-0">
            <div class="card-body d-flex justify-content-center p-1" style="gap: 10px">

                <div class=" px-0 toggle-pill-color-pos d-flex justify-content-center align-items-center flex-column">
                    <input type="checkbox" class="price_filter" id="highest_price" value="highest_price">
                    <label class="checkbox-inline mb-0" for="highest_price">
                    </label>
                    <span class="toggle-pos-label">
                        @lang('lang.highest_price')
                    </span>
                </div>
                <div class=" px-0 toggle-pill-color-pos d-flex justify-content-center align-items-center flex-column">
                    <input type="checkbox" class="price_filter" id="lowest_price" value="lowest_price">
                    <label class="checkbox-inline mb-0" for="lowest_price">

                    </label>
                    <span class="toggle-pos-label">
                        @lang('lang.lowest_price')
                    </span>

                </div>
            </div>
        </div>


        <div class="card mb-0 px-0">
            <div class="card-body d-flex justify-content-center p-1" style="gap: 10px">

                <div class=" px-0 toggle-pill-color-pos d-flex justify-content-center align-items-center flex-column">
                    <input type="checkbox" class="sorting_filter" id="a_to_z" value="a_to_z">
                    <label class="checkbox-inline mb-0" for="a_to_z">
                    </label>
                    <span class="toggle-pos-label">
                        @lang('lang.a_to_z')
                    </span>
                </div>
                <div class=" px-0 toggle-pill-color-pos d-flex justify-content-center align-items-center flex-column">
                    <input type="checkbox" class="sorting_filter" id="z_to_a" value="z_to_a">
                    <label class="checkbox-inline mb-0" for="z_to_a">
                    </label>
                    <span class="toggle-pos-label">
                        @lang('lang.z_to_a')
                    </span>
                </div>
            </div>
        </div>


        <div class="card mb-0 px-0">
            <div class="card-body d-flex justify-content-center p-1" style="gap: 10px">

                <div class=" px-0 toggle-pill-color-pos d-flex justify-content-center align-items-center flex-column">
                    <input type="checkbox" class="expiry_filter" id="nearest_expiry" value="nearest_expiry">
                    <label for="nearest_expiry" class="checkbox-inline mb-0">
                    </label>
                    <span class="toggle-pos-label">
                        @lang('lang.nearest_expiry')
                    </span>
                </div>

                <div class=" px-0 toggle-pill-color-pos d-flex justify-content-center align-items-center flex-column">
                    <input type="checkbox" class="expiry_filter" id="longest_expiry" value="longest_expiry">
                    <label for="longest_expiry" class="checkbox-inline mb-0">
                    </label>
                    <span class="toggle-pos-label">
                        @lang('lang.longest_expiry')
                    </span>
                </div>
            </div>
        </div>

        @endif

        <div class="card mb-0 px-0 @if (session('system_mode') == 'restaurant') hide @endif">
            <div class="card-body d-flex justify-content-center  p-1">

                <div class=" px-0 toggle-pill-color-pos d-flex justify-content-center align-items-center flex-column">

                    <input type="checkbox" id="sale_promo_filter" class="sale_promo_filter"
                        value="items_in_sale_promotion">
                    <label for="sale_promo_filter" class="checkbox-inline mb-0">
                    </label>
                    <span class="toggle-pos-label">
                        @lang('lang.items_in_sale_promotion')
                    </span>
                </div>
            </div>
        </div>


        <div class="card mb-0 px-0 @if (session('system_mode') == 'restaurant') hide @endif">
            <div class="card-body d-flex justify-content-center p-1">

                <div class=" px-0 toggle-pill-color-pos d-flex justify-content-center align-items-center flex-column">
                    <input type="checkbox" class="package_sale_promo_filter" id="package_in_sale_promotion"
                        value="package_in_sale_promotion">
                    <label for="package_in_sale_promotion" class="checkbox-inline mb-0">
                    </label>
                    <span class="toggle-pos-label">
                        @lang('lang.items_in_sale_promotion')
                    </span>
                </div>
            </div>
        </div>


        @if (session('system_mode') == 'restaurant')
        <div class="px-0 filter-btn-div">
            <div class="btn-group btn-group-toggle ml-2 btn-group-custom" data-toggle="buttons">
                <label class="btn btn-primary active filter-btn">
                    <input type="radio" checked autocomplete="off" name="restaurant_filter" id="all_restaurant_filter"
                        value="all">
                    @lang('lang.all')
                </label>
                <label class="btn btn-primary filter-btn">
                    <input type="radio" autocomplete="off" name="restaurant_filter" value="promotions">
                    @lang('lang.promotions')
                </label>
                <label class="btn btn-primary filter-btn">
                    <input type="radio" autocomplete="off" name="restaurant_filter" value="package_promotions">
                    @lang('lang.package_promotions')
                </label>
                @foreach ($product_classes as $product_class)
                <label class="btn btn-primary filter-btn">
                    <input type="radio" name="restaurant_filter" value="{{ $product_class->id }}" autocomplete="off"
                        id="{{ $product_class->name . '_' . $product_class->id }}">
                    {{ ucfirst($product_class->name) }}
                </label>
                @endforeach
            </div>
        </div>
        @endif



    </div>




    <div class=" px-1">
        <div class="card">
            <div class="card-body" style="padding: 0;">
                <div class="col-md-12 mt-1 table-container">
                    <div class="filter-window" style="width: 100% !important; height: 100% !important">
                        <div class="category mt-3">
                            <div class="row ml-2 mr-2 px-2">
                                <div class="col-7">@lang('lang.choose_category')</div>
                                <div class="col-5 text-right">
                                    <span class="btn btn-default btn-sm">
                                        <i class="dripicons-cross"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="row ml-2 mt-3">
                                @foreach ($categories as $category)
                                <div class="col-md-3 filter-by category-img text-center" data-id="{{ $category->id }}"
                                    data-type="category">
                                    <img
                                        src="@if (!empty($category->getFirstMediaUrl('category'))) {{ $category->getFirstMediaUrl('category') }}@else{{ asset('images/default.jpg') }} @endif" />
                                    <p class="text-center">{{ $category->name }}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="sub_category mt-3">
                            <div class="row ml-2 mr-2 px-2">
                                <div class="col-7">@lang('lang.choose_sub_category')</div>
                                <div class="col-5 text-right">
                                    <span class="btn btn-default btn-sm">
                                        <i class="dripicons-cross"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="row ml-2 mt-3">
                                @foreach ($sub_categories as $category)
                                <div class="col-md-3 filter-by category-img text-center" data-id="{{ $category->id }}"
                                    data-type="sub_category">
                                    <img
                                        src="@if (!empty($category->getFirstMediaUrl('category'))) {{ $category->getFirstMediaUrl('category') }}@else{{ asset('images/default.jpg') }} @endif" />
                                    <p class="text-center">{{ $category->name }}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="brand mt-3">
                            <div class="row ml-2 mr-2 px-2">
                                <div class="col-7">@lang('lang.choose_brand')</div>
                                <div class="col-5 text-right">
                                    <span class="btn btn-default btn-sm">
                                        <i class="dripicons-cross"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="row ml-2 mt-3">
                                @foreach ($brands as $brand)
                                <div class="col-md-3 filter-by brand-img text-center" data-id="{{ $brand->id }}"
                                    data-type="brand">
                                    <img
                                        src="@if (!empty($brand->getFirstMediaUrl('brand'))) {{ $brand->getFirstMediaUrl('brand') }}@else{{ asset('images/default.jpg') }} @endif" />
                                    <p class="text-center">{{ $brand->name }}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <table id="filter-product-table" class="table no-shadow product-list"
                        style="width: 100%; border: 0px">
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>