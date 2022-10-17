@extends('admin.layouts.app')

@section('content')
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-black d-inline-block mb-country">Role</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href={{ route('dashboard') }}><i class="fas fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('role') }}">Role</a></li>
                                <li class="breadcrumb-item">Add</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <a href="{{ route('role.add') }}" class="btn btn-lg btn-neutral fade-class"><i
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
                            <h3 class="mb-0">{{ __('Edit') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('role.update', $data->id) }}" autocomplete="off">
                            @csrf
                            @method('post')

                            <h6 class="heading-small text-muted mb-4">{{ __('Edit Role') }}</h6>

                            <div class="pl-lg-4 row">
                                <div class="col-md-4 form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                    <input type="text" name="name" id="input-name"
                                        class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                        value="{{ old('name', $data->name) }}" autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                {{--                                <div class="col-md-4 form-group{{ $errors->has('status') ? ' has-danger' : '' }}"> --}}
                                {{--                                    <label class="form-control-label" for="status">{{ __('Status') }}</label> --}}
                                {{--                                    <select class="form-control" name="status"> --}}
                                {{--                                        @foreach (config('constant.status') as $key => $value) --}}
                                {{--                                            <option value={{ $key }}>{{ $value }}</option> --}}
                                {{--                                        @endforeach --}}
                                {{--                                    </select> --}}
                                {{--                                    @if ($errors->has('status')) --}}
                                {{--                                        <span class="invalid-feedback" role="alert"> --}}
                                {{--                                            <strong>{{ $errors->first('status') }}</strong> --}}
                                {{--                                        </span> --}}
                                {{--                                    @endif --}}
                                {{--                                </div> --}}
                            </div>

                            @foreach (config('permissions_name') as $key => $val)
                                <div class="pl-lg-4 row">
                                    <div class="col-md-2 form-group">
                                        <label class="form-control-label"
                                            for="{{ $key }}">{{ $key }}</label>
                                    </div>

                                    @foreach ($val as $key1 => $val1)
                                        @php
                                            $customValue = setPermissionValue($key, $key1);
                                        @endphp
                                        <div class="col-md-2 form-group">
                                            <label class="checkbox-inline">
                                                <input type="checkbox" name="permissions[]" value="{{ "$key.$key1" }}"
                                                    {{ in_array($customValue, $permissions) ? 'checked' : '' }}>
                                                {{ $val1 }}
                                            </label>
                                        </div>
                                    @endforeach

                                </div>
                            @endforeach
                            <div class="pl-lg-4 row">

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                    <a href="{{ route('role') }}" type="button"
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
