@extends('admin.layouts.app')

@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-black d-inline-block mb-country">Country</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href={{ route('dashboard') }}><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('country') }}">Country</a></li>
                                <li class="breadcrumb-item">Add</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <a href="{{ route('country.add') }}" class="btn btn-lg btn-neutral fade-class"><i class="fas fa-plus fa-lg"></i> New</a>
                        {{--                        <a href="#" class="btn btn-sm btn-neutral">Filters</a>--}}
                    </div>
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
                        <form method="post" action="{{ route('country.store') }}"  autocomplete="off">
                            @csrf
                            @method('post')

                            <h6 class="heading-small text-muted mb-4">{{ __('Add Country ') }}</h6>

                            <div class="pl-lg-4 row">
                                <div class="col-md-4 form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                    <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name', '') }}" autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-4 form-group{{ $errors->has('iso_code_2') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="iso_code_2">{{ __('ISO Code 2') }}</label>
                                    <input type="text" name="iso_code_2" id="iso_code_2" class="form-control form-control-alternative{{ $errors->has('iso_code_2') ? ' is-invalid' : '' }}" placeholder="{{ __('ISO Code 2') }}" value="{{ old('iso_code_2', '') }}" autofocus>

                                    @if ($errors->has('iso_code_2'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('iso_code_2') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-4 form-group{{ $errors->has('iso_code_3') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="iso_code_3">{{ __('ISO Code 3') }}</label>
                                    <input type="text" name="iso_code_3" id="iso_code_3" class="form-control form-control-alternative{{ $errors->has('iso_code_3') ? ' is-invalid' : '' }}" placeholder="{{ __('ISO Code 3') }}" value="{{ old('iso_code_3', '') }}" autofocus>

                                    @if ($errors->has('iso_code_3'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('iso_code_3') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-4 form-group{{ $errors->has('address_format') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="address_format">{{ __('Address Format') }}</label>
                                    <input type="text" name="address_format" id="address_format" class="form-control form-control-alternative{{ $errors->has('address_format') ? ' is-invalid' : '' }}" placeholder="{{ __('Address Format') }}" value="{{ old('address_format', '') }}" autofocus>

                                    @if ($errors->has('address_format'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('address_format') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-4 form-group{{ $errors->has('postcode_required') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="postcode_required">{{ __('Post Code') }}</label>
                                    <input type="text" name="postcode_required" id="postcode_required" class="form-control form-control-alternative{{ $errors->has('postcode_required') ? ' is-invalid' : '' }}" placeholder="{{ __('Post Code') }}" value="{{ old('postcode_required', '') }}" autofocus>

                                    @if ($errors->has('postcode_required'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('postcode_required') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-4 form-group{{ $errors->has('status') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="status">{{ __('Status') }}</label>
                                    <select class="form-control" name="status">
                                        @foreach(config('constant.status') as $key => $value )
                                            <option value={{ $key }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('status'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('status') }}</strong>
                                        </span>
                                    @endif
                                </div>

                            </div>

                            <div class="pl-lg-4 row">

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                    <a href="{{ route('country') }}" type="button" class="btn btn-danger mt-4">{{ __('Cancel') }}</a>
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
@endpush
