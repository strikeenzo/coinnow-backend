@extends('admin.layouts.app')

@section('content')
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-black d-inline-block mb-0">Category</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href={{ route('dashboard') }}><i class="fas fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('category') }}">Category</a></li>
                                <li class="breadcrumb-item">Add</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <a href="{{ route('category.add') }}" class="btn btn-lg btn-neutral fade-class"><i
                                class="fas fa-plus fa-lg"></i> New</a>
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
                        <form method="post" action="{{ route('category.store') }}" enctype="multipart/form-data"
                            autocomplete="off">
                            @csrf
                            @method('post')

                            <h6 class="heading-small text-muted mb-4">{{ __('Add Category ') }}</h6>

                            @if (session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <div class="pl-lg-4 row">
                                <div class="col-md-6 form-group{{ $errors->has('parent_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="parent_id">{{ __('Parent Category') }}</label>
                                    <select class="form-control" name="parent_id">
                                        <option value="0">Select</option>
                                        @foreach ($parentCategory as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('parent_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('parent_id') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-6 form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                    <input type="text" name="name" id="input-name"
                                        class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Name') }}" value="{{ old('name', '') }}" autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-6 form-group{{ $errors->has('meta_title') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Meta Title') }}</label>
                                    <input type="text" name="meta_title" id="meta_title"
                                        class="form-control form-control-alternative{{ $errors->has('meta_title') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Meta Title') }}" value="{{ old('meta_title', '') }}"
                                        autofocus>

                                    @if ($errors->has('meta_title'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('meta_title') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-6 form-group{{ $errors->has('meta_keyword') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Meta Keyword') }}</label>
                                    <input type="text" name="meta_keyword" id="meta_keyword"
                                        class="form-control form-control-alternative{{ $errors->has('meta_keyword') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Meta Keyword') }}" value="{{ old('meta_keyword', '') }}"
                                        autofocus>

                                    @if ($errors->has('meta_keyword'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('meta_keyword') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div
                                    class="col-md-6 form-group{{ $errors->has('meta_description') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Meta Description') }}</label>
                                    <textarea name="meta_description" id="meta_description"
                                        class="form-control form-control-alternative{{ $errors->has('meta_description') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Meta Description') }}" value="{{ old('meta_description', '') }}" rows="3"></textarea>
                                    @if ($errors->has('meta_description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('meta_description') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-6 form-group{{ $errors->has('sort_order') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Sort Order') }}</label>
                                    <input type="number" min="1" name="sort_order" id="sort_order"
                                        value="{{ old('sort_order', '') }}"
                                        class="form-control form-control-alternative{{ $errors->has('sort_order') ? ' is-invalid' : '' }}"
                                        autofocus>
                                    @if ($errors->has('sort_order'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('sort_order') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-6 form-group{{ $errors->has('image') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-email">{{ __('Image') }}</label>
                                    <input type="file" name="image" id="input-email"
                                        class="form-control form-control-alternative{{ $errors->has('image') ? ' is-invalid' : '' }}"
                                        value="{{ old('image', '') }}" required>

                                    @if ($errors->has('image'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('image') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-6 form-group{{ $errors->has('status') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="status">{{ __('Status') }}</label>
                                    <select class="form-control" name="status">
                                        @foreach (config('constant.status') as $key => $value)
                                            <option value={{ $key }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('status'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('status') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                    <a href="{{ route('category') }}" type="button"
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
