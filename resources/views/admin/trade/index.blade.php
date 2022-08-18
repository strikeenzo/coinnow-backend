@extends('admin.layouts.app')

@section('content')

<div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-black d-inline-block mb-0">Trade</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href={{ route('dashboard') }}><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('trade') }}">Trade</a></li>
                                <li class="breadcrumb-item">List</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <a href="{{ route('trade.add') }}" class="btn btn-lg btn-neutral fade-class"><i class="fas fa-plus fa-lg"></i> New</a>
                        {{--                        <a href="#" class="btn btn-sm btn-neutral">Filters</a>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter -->
  <div class="container-fluid mt--6 mb--1">
    <div class="row">
        <div class="card col">
            <div class="card-header border-0">
                    <div class="card card-stats">
                        
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                                    <div class="card card-stats mb-4 mb-xl-0">
                                        <div class="card-body bg-light">
                                            @forelse($trade as $value)
                                            <div class="row my-4">
                                                
                                                <div class="col-auto align-middle">
                                                    <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                                        <i class="fas fa-dollar-sign"></i>
                                                    </div>
                                                </div>  

                                                <div class="col">
                                                    <h5 class="card-title text-muted mb-0 text-green">Reward</h5>
                                                    <span class="h2  mb-0">{{$value->min_reward}}  - {{$value->max_reward}}</span>
                                                </div>
                                                <div class="col">
                                                    <div class="icon icon-shape font-weight-bold shadow">
                                                        x{{$value->quantity_trade}}
                                                    </div>
                                                    @if($value->image)
                                                        <img src="{{asset('/public/uploads/product').'/'.$value->product_image}}"  alt=""  class="img-thumbnail img-fluid" style=" width: 60px;height: 60px;">
                                                    @else
                                                        <img src="{{asset('/assets/img/default.png')}}"  alt="{{$value->name}}"  class="img-thumbnail img-fluid" style=" width: 60px;height: 60px;">
                                                    @endif
                                                </div>
                                                <div class="col-auto align-middle">
                                                    <img src="{{asset($path.'/'.$value->image)}}"  alt="product"  class="img-thumbnail img-fluid" style=" width:40px;height: 40px;">
                                                </div>
                                                
                                            </div>
                                            @empty
                                                <span>No Trade Found</span>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                    </div>
            </div>
        </div>
    </div>
   </div>

@endsection

@push('js')

    <script>
        $(document).on('click','.deleteData',function(){
            let alertMessage = "Are You Sure,You want to delete it ?"
            let routeUrl = $(this).data('url')
            deleteData(alertMessage, routeUrl)
        })
    </script>
@endpush
