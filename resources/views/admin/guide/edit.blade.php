@extends('admin.layouts.app')

@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-black d-inline-block mb-country">Guide</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href={{ route('dashboard') }}><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('guide') }}">Guide</a></li>
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
                        <form method="post" action="{{ route('guide.update', $guide) }}"  autocomplete="off">
                            @csrf
                            @method('post')

                            <h6 class="heading-small text-muted mb-4">{{ __('Edit Guide') }}</h6>

                            <div class="pl-lg-4 row">
                                <div class="col-md-7 form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="title">{{ __('Title') }}</label>
                                    <input type="text" name="title" id="title" class="form-control form-control-alternative{{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="{{ __('Title') }}" value="{{ old('title', $guide->title) }}" autofocus>

                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-7 form-group{{ $errors->has('content') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="content">{{ __('Content') }}</label>
                                    <textarea type="text" name="content" id="content" class="form-control form-control-alternative{{ $errors->has('content') ? ' is-invalid' : '' }}" placeholder="{{ __('Content') }}" autofocus>{{ old('content', $guide->content) }}</textarea>

                                    @if ($errors->has('content'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('content') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-7 form-group{{ $errors->has('sort_order') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="sort_order">{{ __('Sort Order') }}</label>
                                    <input type="number" name="sort_order" id="sort_order" class="form-control form-control-alternative{{ $errors->has('sort_order') ? ' is-invalid' : '' }}" placeholder="{{ __('Sort Order') }}" value="{{ old('sort_order', $guide->sort_order) }}" autofocus>

                                    @if ($errors->has('sort_order'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('sort_order') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-7 form-group{{ $errors->has('type') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="type">{{ __('Type') }}</label>
                                    <select class="form-control" name="type">
                                        <option value="privacy" {{ $guide->type == 'privacy' ? 'selected' : '' }}>Privacy Policy</option>
                                        <option value="term" {{ $guide->type == 'term' ? 'selected' : '' }}>Terms Of Service</option>
                                        <option value="community" {{ $guide->type == 'community' ? 'selected' : '' }}>Community GuideLines</option>
                                    </select>
                                    @if ($errors->has('type'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('type') }}</strong>
                                        </span>
                                    @endif
                                </div>

                            </div>

                            <div class="pl-lg-4 row">

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                    <a href="{{ route('seller') }}" type="button" class="btn btn-danger mt-4">{{ __('Cancel') }}</a>
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
