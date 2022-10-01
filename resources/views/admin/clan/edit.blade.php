@extends('admin.layouts.app')

@section('content')
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-black d-inline-block mb-0">Clan</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href={{ route('dashboard') }}><i class="fas fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('clan') }}">Clan</a></li>
                                <li class="breadcrumb-item">Edit</li>
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
                            <h3 class="mb-0">{{ __('Edit') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('clan.update', $clan->id) }}" enctype="multipart/form-data"
                            autocomplete="off">
                            @csrf
                            @method('post')
                            <h6 class="heading-small text-muted mb-4">{{ __('Edit Clan') }}</h6>
                            <div class="pl-lg-4 row flex justify-content-center">
                                <input name='product_id' value="{{ $clan->product_id }}" hidden/>
                                
                                <div class="col-md-7 form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Title') }}</label>
                                    <input name="title" id="title"
                                        class="form-control form-control-alternative{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('title') }}" autofocus value="{{ old('title', $clan->title) }}" />
                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-7 form-group{{ $errors->has('price') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Price') }}</label>
                                    <input name="price" id="price" type="number"
                                        class="form-control form-control-alternative{{ $errors->has('price') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('price') }}" autofocus value="{{ old('price', $clan->price) }}" />
                                    @if ($errors->has('price'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('price') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-7 form-group{{ $errors->has('fee') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Fee') }}</label>
                                    <input name="fee" id="fee" type="number"
                                        class="form-control form-control-alternative{{ $errors->has('fee') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('fee') }}" autofocus value="{{ old('fee', $clan->fee) }}" />
                                    @if ($errors->has('fee'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('fee') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-7 form-group{{ $errors->has('discount') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Discount') }}</label>
                                    <input name="discount" id="discount" type="number"
                                        class="form-control form-control-alternative{{ $errors->has('discount') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('discount') }}" autofocus value="{{ old('discount', $clan->discount) }}" />
                                    @if ($errors->has('discount'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('discount') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-7 form-group{{ $errors->has('main_image') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-email">{{ __('Image') }}</label>
                                    <input type="file" name="main_image" id="input-email" class="form-control form-control-alternative{{ $errors->has('main_image') ? ' is-invalid' : '' }}" value="{{ old('main_image', '') }}" >
                                    <a target="_blank" href="{{ url(config('constant.file_path.clan')."/$clan->image") }}">View Image</a>

                                    @if ($errors->has('main_image'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('main_image') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="text-center col-md-12">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                    <a href="{{ route('news') }}" type="button"
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
