@extends('admin.layouts.app')

@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-black d-inline-block mb-0">Product</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href={{ route('dashboard') }}><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('product') }}">Product</a></li>
                                <li class="breadcrumb-item">Envrionment</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="mb-0">{{ __('Edit Envrironment Variables') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('env.update') }}"  autocomplete="off">
                            @csrf
                            @method('post')

                            <h6 class="heading-small text-muted mb-4">{{ __('Edit Auto Sell Time') }}</h6>

                            <div class="pl-lg-4 row">
                                <div class="col-md-4 form-group{{ $errors->has('min_time') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="min_time">{{ __('Min Time') }}</label>
                                    <input type="text" name="min_time" id="min_time" class="form-control" value="{{ $min_time }}" autofocus>

                                    @if ($errors->has('min_time'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('min_time') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-4 form-group{{ $errors->has('max_time') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="max_time">{{ __('Max Time') }}</label>
                                    <input type="text" name="max_time" id="max_time" class="form-control" value="{{ $max_time }}" autofocus>

                                    @if ($errors->has('max_time'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('max_time') }}</strong>
                                        </span>
                                    @endif
                                </div>

                            </div>

                            <div class="pl-lg-4 row">

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Update') }}</button>
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
        $(document).on('click','.deleteData',function(){
            let alertMessage = "Are You Sure,You Want to Delete it"
            let routeUrl = $(this).data('url')
            deleteData(alertMessage, routeUrl)
        })
    </script>
@endpush
