@extends('admin.layouts.app')

@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
{{--                        <h6 class="h2 text-black d-inline-block mb-country">Review</h6>--}}
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-bloc-dark">
                                <li class="breadcrumb-item"><a href={{ route('dashboard') }}><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('review') }}">ReviewCustomer </a></li>
                            <li class="breadcrumb-item">View</li>
                        </nav>
                    </div>
                </div>
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="mb-0">{{ __('View') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                            <h6 class="heading-small text-muted mb-4">{{ __('View Review ') }}</h6>
                            <div class="pl-lg-4 row">
                                <div class="col-md-8 form-group">
                                    <label class="form-control-label" for="full_name">{{ __('Customer Name') }} : {{ $data->customer->firstname }} {{ $data->customer->lastname }}</label><br>
                                    <label class="form-control-label" for="input-name">{{ __('Rating') }} : {{ $data->rating }} </label><br>
                                    <label class="form-control-label" for="input-name">{{ __('Description') }} : {{ $data->text }} </label><br>
                                </div>
                            </div>

                            <div class="pl-lg-4 row">
                                <div class="text-center">
                                    <a href="{{ route('review') }}" type="button" class="btn btn-danger mt-4">{{ __('Back') }}</a>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
@endpush
