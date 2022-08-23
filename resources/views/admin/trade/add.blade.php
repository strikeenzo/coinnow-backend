@extends('admin.layouts.app')

@section('content')
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-black d-inline-block mb-0">Trade</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href={{ route('dashboard') }}><i class="fas fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('trade') }}">Trade</a></li>
                                <li class="breadcrumb-item">Add</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- <div class="col-lg-6 col-5 text-right">
                                            <a href="{{ route('trade.add') }}" class="btn btn-lg btn-neutral fade-class"><i class="fas fa-plus fa-lg"></i> New</a>
                                            {{-- <a href="#" class="btn btn-sm btn-neutral">Filters</a> --}}
                                        </div> -->
                </div>
            </div>
        </div>
    </div>

    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="mb-0">{{ __('Add') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('trade.store') }}" enctype="multipart/form-data"
                            autocomplete="off">
                            @csrf
                            @method('post')
                            <h6 class="heading-small text-muted mb-4">{{ __('Add Trade') }}</h6>
                            <div class="pl-lg-4 row">
                                <div class="dropdown col-md-6 form-group">
                                    <label class="form-control-label" for="input-name">{{ __('Product') }}</label>
                                    <input class="form-control" id="product_name" type="text" placeholder="Search..">
                                    <ul class="dropdown-menu mr-4"
                                        style="transform: translateX(20px); height: 200px; overflow: auto;">
                                        @forelse ($records as $key => $value)
                                            <li class="text-center p-2" product-image="{{ $value->image }}"
                                                product-id="{{ $value->id }}" origin-id={{ $value->origin_id }}>
                                                <a href="#">{{ $value->productDescription->name }}</a>
                                            </li>
                                        @empty
                                        @endforelse
                                    </ul>
                                </div>
                                <div class="col-md-6 form-group{{ $errors->has('quantity_trade') ? ' has-danger' : '' }}">
                                    <label class="form-control-label"
                                        for="input-name">{{ __('Product Quantity') }}</label>
                                    <input type="number" min="1" name="quantity_trade" id="quantity_trade"
                                        class="form-control form-control-alternative"
                                        value="{{ old('quantity_trade', '') }}"
                                        placeholder="{{ __('Product Quantity') }}" value="" autofocus>
                                    @if ($errors->has('quantity_trade'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('quantity_trade') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 form-group{{ $errors->has('min_reward') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="min_reward">{{ __('Min') }}</label>
                                    <input type="number" name="min_reward" id="min_reward"
                                        class="form-control form-control-alternative" placeholder="{{ __('Min') }}"
                                        value="" autofocus>

                                    @if ($errors->has('quantity'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('quantity') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 form-group{{ $errors->has('max_reward') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Max') }}</label>
                                    <input type="number" name="max_reward" id="max_reward"
                                        class="form-control form-control-alternative" placeholder="{{ __('Max') }}"
                                        value="" autofocus>
                                    @if ($errors->has('max_reward'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('max_reward') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 form-group{{ $errors->has('quantity') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Quantity To Buy') }}</label>
                                    <input type="number" min="1" name="quantity" id="quantity_trade"
                                        class="form-control form-control-alternative" value="{{ old('quantity', '') }}"
                                        placeholder="{{ __('Quantity to buy') }}" value="" autofocus>
                                    @if ($errors->has('quantity'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('quantity') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 form-group{{ $errors->has('coin_quantity') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Coin Quantity') }}</label>
                                    <input type="number" min="1" name="coin_quantity" id="coin_quantity"
                                        class="form-control form-control-alternative"
                                        value="{{ old('coin_quantity', '') }}" placeholder="{{ __('Coin Quantity') }}"
                                        value="" autofocus>
                                    @if ($errors->has('coin_quantity'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('coin_quantity') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 form-group{{ $errors->has('image') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="image">{{ __('Image') }}</label>
                                    <input type="file" name="image" id="image"
                                        class="form-control form-control-alternative{{ $errors->has('image') ? ' is-invalid' : '' }}"
                                        value="{{ old('image', '') }}" required>

                                    @if ($errors->has('image'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('image') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <input type="hidden" value="" name="product_image"
                                    id="product_image" />
                                    <input type="hidden" value="" name="origin_id"
                                    id="origin_id" />
                                <input type="hidden" value="" name="product_id" id="product_id" />
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                    <a href="{{ route('trade') }}" type="button"
                                        class="btn btn-danger mt-4">{{ __('Cancel') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            var products = [];
            // $("select#product_id").change(function() {
            //     $("input#product_image").val($('option:selected', this).attr("image"));
            // });

            $("#product_name").on("keyup", function() {
                $("form ul").show();
                if ($(this).val() === '')
                    $("form ul").hide();
                var value = $(this).val().toLowerCase();
                $(".dropdown-menu li").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
                $("li").on("click", function() {
                    $("#product_name").val($(this).find("a").text());
                    $("input#product_id").val($(this).attr("product-id"));
                    $("input#product_image").val($(this).attr("product-image"));
                    $("input#origin_id").val($(this).attr("origin-id"));
                    $("form ul").hide();
                });
            });
        });
    </script>
@endpush
