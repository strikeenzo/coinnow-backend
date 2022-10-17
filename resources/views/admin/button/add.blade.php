@extends('admin.layouts.app')

@section('content')
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-black d-inline-block mb-0">Button</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href={{ route('dashboard') }}><i class="fas fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('button') }}">Clan</a></li>
                                <li class="breadcrumb-item">Add</li>
                            </ol>
                        </nav>
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
                        <form method="post" action="{{ route('button.store') }}" enctype="multipart/form-data"
                            autocomplete="off">
                            @csrf
                            @method('post')
                            <h6 class="heading-small text-muted mb-4">{{ __('Add Button Image') }}</h6>
                            <div class="pl-lg-4 row flex justify-content-center">
                                <div class="col-md-7 form-group">
                                    <label class="form-control-label" for="type">{{ __('Type') }}</label>
                                    <select class="form-control {{ $errors->has('type') ? ' is-invalid' : '' }}"
                                        name="type">
                                        <option value="">Select</option>
                                        <option value="1">Clan</option>
                                        <option value="2">Inventory</option>
                                        <option value="3">Barn</option>
                                        <option value="4">Job Offers</option>
                                    </select>
                                    @if ($errors->has('type'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('type') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-7 form-group{{ $errors->has('main_image') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-email">{{ __('Image') }}</label>
                                    <input type="file" name="main_image" id="input-email"
                                        class="form-control form-control-alternative{{ $errors->has('main_image') ? ' is-invalid' : '' }}"
                                        value="{{ old('main_image', '') }}">

                                    @if ($errors->has('main_image'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('main_image') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="text-center col-md-12">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                    <a href="{{ route('button') }}" type="button"
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
@endpush
