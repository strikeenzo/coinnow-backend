@extends('admin.layouts.app')

@section('content')
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-black d-inline-block mb-country">Seller</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href={{ route('dashboard') }}><i class="fas fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('seller') }}">Seller</a></li>
                                <li class="breadcrumb-item">Add</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <a href="{{ route('seller.add') }}" class="btn btn-lg btn-neutral fade-class"><i
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
                        <form method="post" action="{{ route('seller.store') }}" autocomplete="off">
                            @csrf
                            @method('post')

                            <h6 class="heading-small text-muted mb-4">{{ __('Add Seller ') }}</h6>

                            <div class="pl-lg-4 row">
                                <div class="col-md-4 form-group{{ $errors->has('firstname') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="firstname">{{ __('First Name') }}</label>
                                    <input type="text" name="firstname" id="firstname"
                                        class="form-control form-control-alternative{{ $errors->has('firstname') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('First Name') }}" value="{{ old('firstname', '') }}" autofocus>

                                    @if ($errors->has('firstname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('firstname') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-4 form-group{{ $errors->has('lastname') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="lastname">{{ __('Last Name') }}</label>
                                    <input type="text" name="lastname" id="lastname"
                                        class="form-control form-control-alternative{{ $errors->has('lastname') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Last Name') }}" value="{{ old('lastname', '') }}" autofocus>

                                    @if ($errors->has('lastname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('lastname') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-4 form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="email">{{ __('Email') }}</label>
                                    <input type="text" name="email" id="email"
                                        class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Email') }}" value="{{ old('email', '') }}" autofocus>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-4 form-group{{ $errors->has('store_name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="store_name">{{ __('Store Name') }}</label>
                                    <input type="text" name="store_name" id="store_name"
                                        class="form-control form-control-alternative{{ $errors->has('store_name') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Store Name') }}" value="{{ old('store_name', '') }}"
                                        autofocus>

                                    @if ($errors->has('store_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('store_name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-4 form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="password">{{ __('Password') }}</label>
                                    <input type="password" name="password" id="password"
                                        class="form-control form-control-alternative{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Password') }}" value="{{ old('password', '') }}" autofocus>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-4 form-group{{ $errors->has('confirmed') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="confirmed">{{ __('Confirmed') }}</label>
                                    <input type="password" name="confirmed" id="confirmed"
                                        class="form-control form-control-alternative{{ $errors->has('confirmed') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Confirmed') }}" value="{{ old('confirmed', '') }}" autofocus>

                                    @if ($errors->has('confirmed'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('confirmed') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-4 form-group{{ $errors->has('telephone') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="telephone">{{ __('Mobile Number') }}</label>
                                    <input type="text" name="telephone" id="telephone"
                                        class="form-control form-control-alternative{{ $errors->has('telephone') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Mobile Number') }}" value="{{ old('telephone', '') }}"
                                        autofocus>

                                    @if ($errors->has('telephone'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('telephone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-4 form-group{{ $errors->has('status') ? ' has-danger' : '' }}">
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

                                <div class="col-md-4 form-group{{ $errors->has('star_profit') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="star_profit">{{ __('Star Profit') }}</label>
                                    <input type="number" name="star_profit" id="star_profit"
                                        class="form-control form-control-alternative{{ $errors->has('star_profit') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Star Profit') }}" value="{{ old('star_profit', 25) }}"
                                        autofocus>

                                    @if ($errors->has('star_profit'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('star_profit') }}</strong>
                                        </span>
                                    @endif
                                </div>

                            </div>

                            <div class="pl-lg-4 row">

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                    <a href="{{ route('seller') }}" type="button"
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
