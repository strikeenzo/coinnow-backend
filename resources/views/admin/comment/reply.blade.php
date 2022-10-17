@extends('admin.layouts.app')

@section('content')
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-black d-inline-block mb-0">Reply the Comment</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href={{ route('dashboard') }}><i class="fas fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('comments') }}">Comments</a></li>
                                <li class="breadcrumb-item">Reply</li>
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
                            <h3 class="mb-0">{{ __('Reply') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('comments.reply', $comment->id) }}"
                            enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            @method('post')
                            <h6 class="heading-small text-muted mb-4">{{ __('Reply The Comment') }}</h6>
                            <div class="pl-lg-4 row flex justify-content-center">
                                <div class="col-md-6 form-group{{ $errors->has('reply') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Reply') }}</label>
                                    <textarea name="reply" id="reply"
                                        class="form-control form-control-alternative{{ $errors->has('reply') ? ' is-invalid' : '' }}" rows="5"
                                        placeholder="{{ __('reply the comment') }}" autofocus>{{ old('reply', $comment->reply) }}</textarea>
                                    @if ($errors->has('reply'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('reply') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="text-center col-md-12">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                    <a href="{{ route('comments') }}" type="button"
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
