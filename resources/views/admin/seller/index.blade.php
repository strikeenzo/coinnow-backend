@extends('admin.layouts.app')

@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-black d-inline-block">Seller</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href={{ route('dashboard') }}><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('seller') }}">Seller</a></li>
                                <li class="breadcrumb-item">List</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <a href="{{ route('seller.add') }}" class="btn btn-lg btn-neutral fade-class"><i class="fas fa-plus fa-lg"></i> New</a>
                        {{--                        <a href="#" class="btn btn-sm btn-neutral">Filters</a>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="container-fluid mt--6 mb--1">
        <div class="row">
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header border-0">
                        <h3 class="mb-3">Filter</h3>
                        <form action="{{ route('seller') }}">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <input type="text" name="keyword" id="firstname" value="{{ request()->keyword }}" class="form-control form-control-alternative" placeholder="Search by name,email,mobile number" autofocus>
                                </div>
                                <div class="col-md-3 form-group">
                                    <button type="submit" class="btn btn-success"><i class="fas fa-search"></i></button>
                                    <a href="{{ route('seller') }}" class="btn btn-info"><i class="fas fa-sync-alt"></i></a>
                                </div>
                            </div>
                        </form>
                    </div>
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
                                <th scope="col" class="sort" data-sort="name">First Name</th>
                                <th scope="col" class="sort" data-sort="name">Last Name</th>
                                <th scope="col" class="sort" data-sort="name">Email</th>
                                <th scope="col" class="sort" data-sort="name">Store Name</th>
                                <th scope="col" class="sort" data-sort="name">Balance</th>
                                <th scope="col" class="sort" data-sort="name">Inventory</th>
                                <th scope="col" class="sort" data-sort="name">History</th>
                                <th scope="col" class="sort" data-sort="name">Transaction</th>
                                <th scope="col" class="sort" data-sort="name">Mobile Number</th>
                                <th scope="col" class="sort" data-sort="status">Status</th>
                                <th scope="col" class="sort">Action</th>
                            </tr>
                            </thead>
                            <tbody class="list">

                            @forelse($records as $key => $value)

                                <tr>
                                    <td class="budget">{{ $value->firstname }}</td>
                                    <td class="budget">{{ $value->lastname }}</td>
                                    <td class="budget">{{ $value->email }}</td>
                                    <td class="budget">{{ $value->store_name }}</td>
                                    <td class="budget">{{ $value->balance }}</td>
                                    <td class="budget">
                                        <ul>
                                            @foreach($value->products as $key => $inventory)
                                                @if($inventory->pivot->quantity > 0)
                                                    <li>
                                                        {{ $inventory->productDescription->name." * ".$inventory->pivot->quantity }}
                                                        @if($inventory->pivot->sale)
                                                        (list for sale)
                                                        @endif
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="budget"><a href="{{ route('seller.history', $value->id) }}">history</a></td>
                                    <td class="budget"><a href="{{ route('transaction_history', $value->id) }}">transaction</a></td>
                                    <td class="budget">{{ $value->telephone }}</td>
                                    <td class="budget"><span class="p-2  @if($value->status == 1) badge bg-success text-white  @else  badge bg-danger text-white @endif">{{  config('constant.status')[$value->status] }} </span></td>

                                    <td class="">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-dark" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item" href="{{ route('seller.edit',['id' => $value->id]) }}">Edit</a>
                                                <a class="dropdown-item deleteData" type="button"  href="javascript:void(0)" data-url="{{ route('seller.delete',['id' => $value->id]) }}">Delete</a>
                                            </div>
                                        </div>
                                    </td>
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
                    <div class="card-footer py-4">
                        {{ $records->appends(['firstname' => request()->name])->links() }}
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
