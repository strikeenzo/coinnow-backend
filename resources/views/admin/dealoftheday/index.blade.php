@extends('admin.layouts.app')
@prepend('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

@endprepend
@section('content')

    <div class="header bg-primary pb-3">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-black d-inline-block mb-0"> Deals Of The Day</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href={{ route('dashboard') }}><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('category') }}"> Deals Of The Day</a></li>
                                <li class="breadcrumb-item">List</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid">
        <div class="row  ">
            <div class="col">
                <div class="card">
                  <form method="post" id="data-form" action="{{ route('trending_dod.store') }}" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    @method('post')
                    <div class="col-md-10  mt-3 ml-8 form-group{{ $errors->has('product_id') ? ' has-danger' : '' }}">
                      <label class="form-control-label" for="parent_id">{{ __('Add Product To Deals Of The Day') }}</label>
                      <select class="form-control selectpicker " multiple data-live-search="true" name="product_id[]" >
                          @foreach($data['pluckProducts'] as $key => $value )
                              <option value={{ $key }} {{ in_array($key,$data['pluckDODProducts']) ? 'selected' : '' }}>{{ $value }}</option>
                          @endforeach
                      </select>
                  </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success btn-lg mb-3"><i class="fa fa-plus"></i> {{ __('Add Selected Products To Deals Of The Day') }}</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

    <!-- Page content -->
    <div class="container-fluid ">
        <div class="row">
            <div class="col">
                <div class="card">

                    <!-- Card header -->

                    <!-- Light table -->
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                          <thead class="thead-dark">
                          <tr>
                              <th scope="col" class="sort" data-sort="name">Image</th>
                              <th scope="col" class="sort" data-sort="name">Name</th>
                              <th scope="col" class="sort" data-sort="parent_id">Price</th>
                              <th scope="col" class="sort" data-sort="status">Special Price</th>
                          </tr>
                          </thead>
                          <tbody class="list">
                          @forelse($records as $key => $value)
                              <tr>
                                <td>
                                  @if($value->productDetails && $value->productDetails->image)
                                    <img src="{{asset('/public/uploads/product').'/'.$value->productDetails->image}}"  alt="{{$value->productDescription->name}}"  class="img-thumbnail img-fluid" style=" width: 60px;height: 60px;">
                                  @else
                                    <img src="{{asset('/assets/img/default.png')}}"  alt="{{$value->productDescription->name}}"  class="img-thumbnail img-fluid" style=" width: 60px;height: 60px;">
                                  @endif
                                </td>

                                  <td class="budget">{{ $value->productDescription ? $value->productDescription->name : '' }}</td>
                                  <td class="budget">${{ $value->productDetails->price }}</td>
                                  <td class="budget">${{ $value->productSpecial ? $value->productSpecial->price : 0 }}</td>
                              </tr>
                          @empty
                              <tr>
                                  <td colspan="10" class="budget">
                                      No Record Found
                                  </td>
                              </tr>
                          @endforelse
                          </tbody>


                        </table>
                    </div>
                    <!-- Card footer -->

                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script>
     $( document ).ready(function() {
        $('selectpicker').selectpicker();
    });
    </script>
@endpush
