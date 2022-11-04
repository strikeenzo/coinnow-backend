<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header  align-items-center">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <h6 class="h2 text-white d-inline-block mb-0">Admin Panel</h6>
            </a>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">
                    @if ($user->hasRole('Admin'))
                        <li class="nav-item ">
                            <a class="nav-link @if (Request::is('admin/dashboard')) active @endif"
                                href="{{ route('dashboard') }}">
                                <i class="ni ni-tv-2 text-primary"></i> {{ __('Dashboard') }}
                            </a>
                        </li>
                    @endif

                    @if ($user->hasRole('Admin'))
                        <li class="nav-item">
                            <a class="nav-link @if (Request::is('admin/trade')) active @endif" href="#navbar-trade"
                                data-toggle="collapse" role="button" aria-expanded="false"
                                aria-controls="navbar-examples">
                                <i class="fas fa-user-tie fa-lg"></i>
                                <span class="nav-link-text">
                                    {{ __('Trade') }}
                                </span>
                            </a>

                            <div class="collapse" id="navbar-trade">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('trade.add') }}">
                                            <i class="fa fa-plus fa-lg"></i> {{ __('Add') }}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('trade') }}">
                                            <i class="fa fa-list-alt fa-lg"></i> {{ __('List') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif

                    @if ($user->hasRole('Admin'))
                        <li class="nav-item">
                            <a class="nav-link" href="#navbar-catelog" data-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="navbar-examples">
                                <i class="fa fa-list-alt fa-lg"></i>
                                <span class="nav-link-text"> {{ __('Catalog') }} </span>
                            </a>
                            <ul class="nav nav-sm flex-column">
                                <div class="collapse" id="navbar-catelog">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#navbar-category" data-toggle="collapse"
                                            role="button" aria-expanded="false" aria-controls="navbar-examples">
                                            <i class="fas fa-tasks fa-lg"></i>
                                            <span class="nav-link-text">
                                                {{ __('Categories') }}
                                            </span>
                                        </a>
                                        <ul class="nav nav-sm flex-column">
                                            <div class="collapse" id="navbar-category">
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('category.add') }}">
                                                        <i class="fa fa-plus fa-lg"></i> {{ __('Add') }}
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('category') }}">
                                                        <i class="fa fa-list-alt fa-lg"></i> {{ __('List') }}
                                                    </a>
                                                </li>
                                            </div>
                                        </ul>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="#navbar-products" data-toggle="collapse"
                                            role="button" aria-expanded="false" aria-controls="navbar-examples">
                                            <i class="fas fa-box fa-lg"></i>
                                            <span class="nav-link-text">
                                                {{ __('Products') }}
                                            </span>
                                        </a>
                                        <ul class="nav nav-sm flex-column">
                                            <div class="collapse" id="navbar-products">
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('product.add') }}">
                                                        <i class="fa fa-plus fa-lg"></i> {{ __('Add') }}
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('product') }}">
                                                        <i class="fa fa-list-alt fa-lg"></i> {{ __('List') }}
                                                    </a>
                                                </li>
                                            </div>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('clan') }}" role="button">
                                            <i class="fas fa-box fa-lg"></i>
                                            <span class="nav-link-text">
                                                {{ __('Clans') }}
                                            </span>
                                        </a>
                                    </li>

                                    <!--                                <li class="nav-item">
                                    <a class="nav-link" href="#navbar-coupon" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                                      <i class="fas fa-percent"></i>
                                        <span class="nav-link-text" >
                                        {{ __('Coupon') }}
                                    </span>
                                    </a>
                                    <ul class="nav nav-sm flex-column">
                                        <div class="collapse" id="navbar-coupon">
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('coupon.add') }}">
                                                    <i class="fa fa-plus fa-lg"></i> {{ __('Add') }}
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('coupon') }}">
                                                    <i class="fa fa-list-alt fa-lg"></i> {{ __('List') }}
                                                </a>
                                            </li>
                                        </div>
                                    </ul>
                                </li>-->
                                    <!--                                <li class="nav-item">
                                  <a class="nav-link" href="#navbar-product-option" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                                      <i class="fa fa-list-alt fa-lg"></i>
                                      <span class="nav-link-text" style="color: #f4645f;">
                                      {{ __('Options') }}
                                  </span>
                                  </a>
                                  <ul class="nav nav-sm flex-column">
                                      <div class="collapse" id="navbar-product-option">
                                          <li class="nav-item">
                                              <a class="nav-link" href="{{ route('product-option.add') }}">
                                                <i class="fa fa-plus fa-lg"></i> {{ __('Add') }}
                                            </a>
                                          </li>
                                          <li class="nav-item">
                                              <a class="nav-link" href="{{ route('product-option') }}">
                                                  <i class="fa fa-list-alt fa-lg"></i> {{ __('List') }}
                                              </a>
                                          </li>
                                      </div>
                                  </ul>
                                </li>-->
                                    <!--                                <li class="nav-item">
                                    <a class="nav-link" href="#navbar-manufacturer" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                                        <i class="fas fa-industry fa-lg"></i>
                                        <span class="nav-link-text" >
                                        {{ __('Manufacturers') }}
                                    </span>
                                    </a>
                                    <ul class="nav nav-sm flex-column">
                                        <div class="collapse" id="navbar-manufacturer">
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('manufacturer.add') }}">
                                                    <i class="fa fa-plus fa-lg"></i> {{ __('Add') }}
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('manufacturer') }}">
                                                    <i class="fa fa-list-alt fa-lg"></i> {{ __('List') }}
                                                </a>
                                            </li>
                                        </div>
                                    </ul>
                                </li>-->

                                    <!--                                <li class="nav-item">
                                    <a class="nav-link" href="#navbar-product-attribute-group" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                                      <i class="fas fa-th fa-lg"></i>
                                      <span class="nav-link-text" >
                                        {{ __('Attribute Group') }}
                                    </span>
                                    </a>
                                    <ul class="nav nav-sm flex-column">
                                        <div class="collapse" id="navbar-product-attribute-group">
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('product-attribute-group.add') }}">
                                                    <i class="fa fa-plus fa-lg"></i> {{ __('Add') }}
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('product-attribute-group') }}">
                                                    <i class="fa fa-list-alt fa-lg"></i> {{ __('List') }}
                                                </a>
                                            </li>
                                        </div>
                                    </ul>
                                </li>-->

                                    <!--                                <li class="nav-item">
                                    <a class="nav-link" href="#navbar-product-attribute" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                                      <i class="fas fa-th fa-lg"></i>
                                        <span class="nav-link-text" >
                                        {{ __('Product Attribute') }}
                                    </span>
                                    </a>
                                    <ul class="nav nav-sm flex-column">
                                        <div class="collapse" id="navbar-product-attribute">
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('product-attribute.add') }}">
                                                    <i class="fa fa-plus fa-lg"></i> {{ __('Add') }}
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('product-attribute') }}">
                                                    <i class="fa fa-list-alt fa-lg"></i> {{ __('List') }}
                                                </a>
                                            </li>
                                        </div>
                                    </ul>
                                </li>-->

                                    <!--                                <li class="nav-item">
                                    <a class="nav-link" href="#navbar-review" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                                    <i class="fas fa-star"></i>
                                        <span class="nav-link-text" >
                                        {{ __('Reviews') }}
                                    </span>
                                    </a>
                                    <ul class="nav nav-sm flex-column">
                                        <div class="collapse" id="navbar-review">
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('review') }}">
                                                    <i class="fa fa-list-alt fa-lg"></i> {{ __('List') }}
                                                </a>
                                            </li>
                                        </div>
                                    </ul>
                                </li>-->
                                </div>
                            </ul>
                        </li>
                    @endif

                    @if ($user->hasRole('Admin'))
                        <li class="nav-item">
                            <a class="nav-link" href="#navbar-system" data-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="navbar-examples">
                                <i class="fas fa-laptop fa-lg"></i>
                                <span class="nav-link-text"> {{ __('System') }} </span>
                            </a>
                            <ul class="nav nav-sm flex-column">
                                <div class="collapse" id="navbar-system">

                                    <li class="nav-item">
                                        <a class="nav-link" href="#navbar-tax-rate" data-toggle="collapse"
                                            role="button" aria-expanded="false" aria-controls="navbar-examples">
                                            <i class="fas fa-shipping-fast"></i>
                                            <span class="nav-link-text">
                                                {{ __('Shipping') }}
                                            </span>
                                        </a>
                                        <ul class="nav nav-sm flex-column">
                                            <div class="collapse" id="navbar-tax-rate">
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('shipping.add') }}">
                                                        <i class="fa fa-plus fa-lg"></i> {{ __('Add') }}
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('shipping') }}">
                                                        <i class="fa fa-list-alt fa-lg"></i> {{ __('List') }}
                                                    </a>
                                                </li>
                                            </div>
                                        </ul>
                                    </li>

                                    <!--                                <li class="nav-item">
                                    <a class="nav-link" href="#navbar-length-class" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                                        <i class="fas fa-ruler-vertical fa-lg"></i>
                                        <span class="nav-link-text" >
                                        {{ __('Length Class') }}
                                    </span>
                                    </a>
                                    <ul class="nav nav-sm flex-column">
                                        <div class="collapse" id="navbar-length-class">
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('length-class.add') }}">
                                                    <i class="fa fa-plus fa-lg"></i> {{ __('Add') }}
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('length-class') }}">
                                                    <i class="fa fa-list-alt fa-lg"></i> {{ __('List') }}
                                                </a>
                                            </li>
                                        </div>
                                    </ul>
                                </li>-->

                                    <!--                                <li class="nav-item">
                                    <a class="nav-link" href="#navbar-weight-class" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                                      <i class="fas fa-weight fa-lg"></i>
                                        <span class="nav-link-text" >
                                        {{ __('Weight Class') }}
                                    </span>
                                    </a>
                                    <ul class="nav nav-sm flex-column">
                                        <div class="collapse" id="navbar-weight-class">
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('weight-class.add') }}">
                                                    <i class="fa fa-plus fa-lg"></i> {{ __('Add') }}
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('weight-class') }}">
                                                    <i class="fa fa-list-alt fa-lg"></i> {{ __('List') }}
                                                </a>
                                            </li>
                                        </div>
                                    </ul>
                                </li>-->

                                    <li class="nav-item">
                                        <a class="nav-link" href="#navbar-order-status" data-toggle="collapse"
                                            role="button" aria-expanded="false" aria-controls="navbar-examples">
                                            <i class="fas fa-tag fa-lg"></i>
                                            <span class="nav-link-text">
                                                {{ __('Order Status') }}
                                            </span>
                                        </a>
                                        <ul class="nav nav-sm flex-column">
                                            <div class="collapse" id="navbar-order-status">
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('order-status.add') }}">
                                                        <i class="fa fa-plus fa-lg"></i> {{ __('Add') }}
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('order-status') }}">
                                                        <i class="fa fa-list-alt fa-lg"></i> {{ __('List') }}
                                                    </a>
                                                </li>
                                            </div>
                                        </ul>
                                    </li>

                                    <!--                                <li class="nav-item">
                                    <a class="nav-link" href="#navbar-stock-status" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                                        <i class="fas fa-cubes fa-lg"></i>
                                        <span class="nav-link-text" >
                                        {{ __('Stock Status') }}
                                    </span>
                                    </a>
                                    <ul class="nav nav-sm flex-column">
                                        <div class="collapse" id="navbar-stock-status">
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('stock-status.add') }}">
                                                    <i class="fa fa-plus fa-lg"></i> {{ __('Add') }}
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('stock-status') }}">
                                                    <i class="fa fa-list-alt fa-lg"></i> {{ __('List') }}
                                                </a>
                                            </li>
                                        </div>
                                    </ul>
                                </li>-->

                                    <li class="nav-item">
                                        <a class="nav-link" href="#navbar-country" data-toggle="collapse"
                                            role="button" aria-expanded="false" aria-controls="navbar-examples">
                                            <i class="fas fa-globe-asia fa-lg"></i>
                                            <span class="nav-link-text">
                                                {{ __('Countries') }}
                                            </span>
                                        </a>
                                        <ul class="nav nav-sm flex-column">
                                            <div class="collapse" id="navbar-country">
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('country.add') }}">
                                                        <i class="fa fa-plus fa-lg"></i> {{ __('Add') }}
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('country') }}">
                                                        <i class="fa fa-list-alt fa-lg"></i> {{ __('List') }}
                                                    </a>
                                                </li>
                                            </div>
                                        </ul>
                                    </li>

                                    <!--                                <li class="nav-item">
                                    <a class="nav-link" href="#navbar-tax-rate" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                                      <i class="fas fa-percentage fa-lg"></i>
                                        <span class="nav-link-text" >
                                        {{ __('Tax Rate') }}
                                    </span>
                                    </a>
                                    <ul class="nav nav-sm flex-column">
                                        <div class="collapse" id="navbar-tax-rate">
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('tax-rate.add') }}">
                                                    <i class="fa fa-plus fa-lg"></i> {{ __('Add') }}
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('tax-rate') }}">
                                                    <i class="fa fa-list-alt fa-lg"></i> {{ __('List') }}
                                                </a>
                                            </li>
                                        </div>
                                    </ul>
                                </li>-->
                                </div>
                            </ul>
                        </li>
                    @endif

                    @if ($user->hasRole('Admin'))
                        <li class="nav-item">
                            <a class="nav-link" href="#navbar-customer" data-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="navbar-examples">
                                <i class="fas fa-user-tie fa-lg"></i>
                                <span class="nav-link-text">
                                    {{ __('Customer') }}
                                </span>
                            </a>

                            <div class="collapse" id="navbar-customer">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('customer.add') }}">
                                            <i class="fa fa-plus fa-lg"></i> {{ __('Add') }}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('customer') }}">
                                            <i class="fa fa-list-alt fa-lg"></i> {{ __('List') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif


                    @if ($user->hasRole('Admin'))
                        <li class="nav-item">
                            <a class="nav-link" href="#navbar-seller" data-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="navbar-examples">
                                <i class="fas fa-user-tie fa-lg"></i>
                                <span class="nav-link-text">
                                    {{ __('Seller') }}
                                </span>
                            </a>

                            <div class="collapse" id="navbar-seller">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('seller.add') }}">
                                            <i class="fa fa-plus fa-lg"></i> {{ __('Add') }}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('seller') }}">
                                            <i class="fa fa-list-alt fa-lg"></i> {{ __('List') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif
                    @if ($user->hasRole('Admin'))
                        <li class="nav-item">
                            <a class="nav-link" href="#navbar-sales" data-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="navbar-examples">
                                <i class="fas fa-sort-amount-up-alt fa-lg"></i>
                                <span class="nav-link-text"> {{ __('Sales') }} </span>
                            </a>
                            <ul class="nav nav-sm flex-column">
                                <div class="collapse" id="navbar-sales">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#navbar-order" data-toggle="collapse"
                                            role="button" aria-expanded="false" aria-controls="navbar-examples">
                                            <i class="fas fa-chart-area fa-lg"></i>
                                            <span class="nav-link-text">
                                                {{ __('Orders') }}
                                            </span>
                                        </a>
                                        <ul class="nav nav-sm flex-column">
                                            <div class="collapse" id="navbar-order">
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('order') }}">
                                                        <i class="fa fa-list-alt fa-lg"></i> {{ __('List') }}
                                                    </a>
                                                </li>
                                            </div>
                                        </ul>
                                    </li>
                                </div>
                            </ul>
                        </li>
                    @endif
                    @if ($user->hasRole('Admin'))
                        <li class="nav-item">
                            <a class="nav-link" href="#navbar-user" data-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="navbar-examples">
                                <i class="fa fa-users fa-lg"></i>
                                <span class="nav-link-text">{{ __('User') }}</span>
                            </a>
                            <div class="collapse" id="navbar-user">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('user.add') }}">
                                            <i class="fa fa-plus fa-lg"></i> {{ __('Add') }}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('user') }}">
                                            <i class="fa fa-list-alt fa-lg"></i> {{ __('List') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif
                    @if ($user->hasRole('Admin'))
                        <li class="nav-item">
                            <a class="nav-link" href="#navbar-news" data-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="navbar-examples">
                                <i class="fa fa-newspaper fa-lg"></i>
                                <span class="nav-link-text">{{ __('News') }}</span>
                            </a>
                            <div class="collapse" id="navbar-news">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('news.add') }}">
                                            <i class="fa fa-plus fa-lg"></i> {{ __('Add') }}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('news') }}">
                                            <i class="fa fa-list-alt fa-lg"></i> {{ __('News') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif
                    @if ($user->hasRole('Admin'))
                        <li class="nav-item">
                            <a class="nav-link" href="#navbar-guide" data-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="navbar-examples">
                                <i class="fa fa-book fa-lg"></i>
                                <span class="nav-link-text">{{ __('Guide') }}</span>
                            </a>
                            <div class="collapse" id="navbar-guide">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('guide.add') }}">
                                            <i class="fa fa-plus fa-lg"></i> {{ __('Add') }}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('guide') }}">
                                            <i class="fa fa-list-alt fa-lg"></i> {{ __('Guide') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif

                    @if ($user->hasRole('Admin'))
                        <li class="nav-item">
                            <a class="nav-link" href="#navbar-payment" data-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="navbar-examples">
                                <i class="fa fa-credit-card fa-lg"></i>
                                <span class="nav-link-text">{{ __('Payment') }}</span>
                            </a>
                            <div class="collapse" id="navbar-payment">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('coinPrice') }}">
                                            <i class="fa fa-list-alt fa-lg"></i> {{ __('Coin Price') }}
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('coinPrice.paymentHistory') }}">
                                            <i class="fa fa-list-alt fa-lg"></i> {{ __('History') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif

                    @if (false && $user->hasRole('Admin'))
                        <li class="nav-item">
                            <a class="nav-link" href="#navbar-cms" data-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="navbar-examples">
                                <i class="fa fa-edit fa-lg"></i>
                                <span class="nav-link-text">{{ __('CMS') }}</span>
                            </a>
                            <div class="collapse" id="navbar-cms">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('pages') }}">
                                            <i class="fa fa-list fa-lg"></i> {{ __('Manage CMS') }}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('trending_dod') }}">
                                            <i class="fab fa-ideal"></i> {{ __('Deals Of The Day') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>

                        </li>
                    @endif

                    @if (false && $user->hasRole('Admin'))
                        <li class="nav-item">
                            <a class="nav-link" href="#navbar-role-permission" data-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="navbar-examples">
                                <i class="fas fa-user-secret fa-lg"></i>
                                <span class="nav-link-text"> {{ __('Roles & Permissions') }} </span>
                            </a>
                            <ul class="nav nav-sm flex-column">
                                <div class="collapse" id="navbar-role-permission">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#navbar-role" data-toggle="collapse"
                                            role="button" aria-expanded="false" aria-controls="navbar-examples">
                                            <i class="fas fa-user fa-lg"></i>
                                            <span class="nav-link-text">
                                                {{ __('Role') }}
                                            </span>
                                        </a>
                                        <ul class="nav nav-sm flex-column">
                                            <div class="collapse" id="navbar-role">
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('role.add') }}">
                                                        <i class="fa fa-plus fa-lg"></i> {{ __('Add') }}
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('role') }}">
                                                        <i class="fa fa-list-alt fa-lg"></i> {{ __('List') }}
                                                    </a>
                                                </li>
                                            </div>
                                        </ul>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="#navbar-permission" data-toggle="collapse"
                                            role="button" aria-expanded="false" aria-controls="navbar-examples">
                                            <i class="fas fa-hand-rock fa-lg"></i>
                                            <span class="nav-link-text">
                                                {{ __('Permission') }}
                                            </span>
                                        </a>
                                        <ul class="nav nav-sm flex-column">
                                            <div class="collapse" id="navbar-permission">
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('permission') }}">
                                                        <i class="fa fa-list-alt fa-lg"></i> {{ __('List') }}
                                                    </a>
                                                </li>
                                            </div>
                                        </ul>
                                    </li>
                                </div>
                            </ul>
                        </li>
                    @endif
                    @if (false && $user->hasRole('Admin'))
                        <li class="nav-item">
                            <a class="nav-link" href="#navbar-designs" data-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="navbar-examples">
                                <i class="fas fa-fill-drip fa-lg"></i>
                                <span class="nav-link-text"> {{ __('Design') }} </span>
                            </a>
                            <ul class="nav nav-sm flex-column">
                                <div class="collapse" id="navbar-designs">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#navbar-banner" data-toggle="collapse"
                                            role="button" aria-expanded="false" aria-controls="navbar-examples">
                                            <i class="fas fa-images fa-lg"></i>
                                            <span class="nav-link-text">
                                                {{ __('Banner') }}
                                            </span>
                                        </a>
                                        <ul class="nav nav-sm flex-column">
                                            <div class="collapse" id="navbar-banner">
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('banner.add') }}">
                                                        <i class="fa fa-plus fa-lg"></i> {{ __('Add') }}
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('banner') }}">
                                                        <i class="fa fa-list-alt fa-lg"></i> {{ __('List') }}
                                                    </a>
                                                </li>
                                            </div>
                                        </ul>
                                    </li>
                                </div>
                            </ul>
                        </li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('comments') }}">
                            <i class="fa fa-box"></i> {{ __('Customer Support Center') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('digital') }}">
                            <i class="fa fa-image"></i> {{ __('Digital Show') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('fee') }}">
                            <i class="fa fa-money-bill"></i> {{ __('Everyday Fee') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('gift') }}">
                            <i class="fa fa-money-bill"></i> {{ __('Gift') }}
                        </a>
                    </li>
                    @if ($user->hasRole('Admin'))
                        <li class="nav-item">
                            <a class="nav-link" href="#navbar-history" data-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="navbar-examples">
                                <i class="fa fa-history fa-lg"></i>
                                <span class="nav-link-text">{{ __('History') }}</span>
                            </a>
                            <div class="collapse" id="navbar-history">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('auto_sell_history') }}">
                                            <i class="fa fa-list fa-lg"></i> {{ __('Auto Sell') }}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('transaction_history', 0) }}">
                                            <i class="fa fa-list fa-lg"></i> {{ __('Transaction') }}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('auto_price_history') }}">
                                            <i class="fa fa-list fa-lg"></i> {{ __('Auto Price') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif

                    @if ($user->hasRole('Admin'))
                        <li class="nav-item">
                            <a class="nav-link" href="#navbar-environments" data-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="navbar-examples">
                                <i class="fa fa-history fa-lg"></i>
                                <span class="nav-link-text">{{ __('Environments') }}</span>
                            </a>
                            <div class="collapse" id="navbar-environments">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('env') }}">
                                            <i class="fa fa-cog"></i> {{ __('Variables') }}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('button') }}">
                                            <i class="fa fa-list fa-lg"></i> {{ __('Button Images') }}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('question') }}">
                                            <i class="fa fa-list fa-lg"></i> {{ __('Questions') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif

                </ul>
            </div>
        </div>
    </div>
</nav>
