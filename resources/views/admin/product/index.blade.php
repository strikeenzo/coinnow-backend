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
                                <li class="breadcrumb-item"><a href={{ route('dashboard') }}><i class="fas fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('product') }}">Product</a></li>
                                <li class="breadcrumb-item">List</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <a href="{{ route('product.add') }}" class="btn btn-lg btn-neutral fade-class"><i
                                class="fas fa-plus fa-lg"></i> New</a>
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
                        <form action="{{ route('product') }}">
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <input type="text" name="name" id="name" value="{{ request()->name }}"
                                        class="form-control form-control-alternative" placeholder="Search by name"
                                        autofocus>
                                </div>
                                <div class="col-md-3 form-group">
                                    <input type="text" name="model" id="model" value="{{ request()->model }}"
                                        class="form-control form-control-alternative" placeholder="Search by model">
                                </div>
                                <div class="col-md-2 form-group">
                                    <input type="number" name="quantity" id="quantity" value="{{ request()->quantity }}"
                                        class="form-control form-control-alternative" placeholder="Search by quantity">
                                </div>

                                <div class="col-md-2 form-group">
                                    <select class="form-control" name="status">
                                        <option value="1" @if ($status == 1) selected="true" @endif>
                                            Active</option>
                                        <option value="0" @if ($status == 0) selected="true" @endif>
                                            DeActive</option>
                                    </select>
                                </div>
                                <div class="col-md-2 form-group">
                                    <button type="submit" class="btn btn-success"><i class="fas fa-search"></i></button>
                                    <a href="{{ route('product') }}" class="btn btn-info"><i
                                            class="fas fa-sync-alt"></i></a>
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
                                    <th style="font-size: 10px" scope="col" class="sort" data-sort="name"
                                        style="font-size: 10px">Product</th>
                                    <th style="font-size: 10px" scope="col" class="sort" data-sort="name">Name</th>
                                    <th style="font-size: 10px" scope="col" class="sort" data-sort="status">Category
                                    </th>
                                    <th style="font-size: 10px" scope="col" class="sort" data-sort="model">Model</th>
                                    <th style="font-size: 10px" scope="col" class="sort" data-sort="quantity">Quantity
                                    </th>
                                    <th style="font-size: 10px" scope="col" class="sort" data-sort="quantity">Amount
                                    </th>
                                    <th style="font-size: 10px;" scope="col" class="sort" data-sort="quantity">Sellers'
                                        Quantity</th>
                                    <th style="font-size: 10px" scope="col" class="sort" data-sort="quantity">Clan
                                        Members</th>
                                    <th style="font-size: 10px" scope="col" class="sort" style="min-width: 150px;"
                                        data-sort="quantity">Price</th>
                                    <th style="font-size: 10px" scope="col" class="sort" style="min-width: 150px;"
                                        data-sort="quantity">Origin Price</th>
                                    <th style="font-size: 10px" scope="col" class="sort" data-sort="quantity">price
                                        change</th>
                                    <th style="font-size: 10px" scope="col" class="sort" data-sort="sort_order">
                                        Sort Order</th>
                                    <th style="font-size: 10px" scope="col" class="sort" data-sort="status">Status
                                    </th>
                                    <th style="font-size: 10px" scope="col" class="sort">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">

                                @forelse($records as $key => $value)
                                    <tr>
                                        <td class="budget">
                                            @if ($value->image)
                                                <img src="{{ asset('/public/uploads/product') . '/' . $value->image }}"
                                                    alt="{{ $value->name }}" class="img-thumbnail img-fluid"
                                                    style=" width: 60px;height: 60px;">
                                            @else
                                                <img src="{{ asset('/assets/img/default.png') }}"
                                                    alt="{{ $value->name }}" class="img-thumbnail img-fluid"
                                                    style=" width: 60px;height: 60px;">
                                            @endif
                                        </td>
                                        <td class="budget">{{ $value->productDescription->name }}</td>
                                        <td class="budget">
                                            {{ isset($value->category->name) ? $value->category->name : 'No Category' }}
                                        </td>
                                        <td class="budget">{{ $value->model }}</td>
                                        <td class="budget "> <span
                                                class="@if ($value->quantity < 5) badge badge-danger btn-small @else badge badge-success btn-small @endif"
                                                style="font-size:12px;">{{ $value->quantity }}</span></td>
                                        <td class="budget "> <span
                                                class="@if ($value->amount < 5) badge badge-danger btn-small @else badge badge-success btn-small @endif"
                                                style="font-size:12px;">{{ $value->amount ? $value->amount : 0 }}</span>
                                        </td>
                                        <td class="budget text-center"> <span
                                                class="@if ($value->total_quantity < 5) badge badge-danger btn-small @else badge badge-success btn-small @endif"
                                                style="font-size:12px;">{{ $value->total_quantity }}</span></td>
                                        <td class="budget "> <span
                                                class="@if ($value->clan_members < 5) badge badge-danger btn-small @else badge badge-success btn-small @endif"
                                                style="font-size:12px;">{{ $value->clan_members }}</span></td>
                                        <td class="budget">
                                            {{ $value->price }}
                                        </td>
                                        <td class="budget" style="min-width: 120px;">
                                            <form action="{{ route('product.updatePrice', ['id' => $value->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('post')
                                                <input type="number" name="price" class="form-control"
                                                    value="{{ $value->origin_price }}">
                                            </form>
                                        </td>
                                        <td class="budget ">
                                            <form action="{{ route('product.updatePriceChange', ['id' => $value->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('post')
                                                <input type="number" name="change_amount" class="form-control"
                                                    value="{{ $value->change_amount ? $value->change_amount : 0 }}">
                                            </form>
                                        </td>
                                        <td class="budget">{{ $value->sort_order }}</td>
                                        <td class="budget"><span
                                                class="p-2  @if ($value->status == 1) badge bg-success text-white  @else  badge bg-danger text-white @endif">{{ config('constant.status')[$value->status] }}
                                            </span></td>
                                        <td class="">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-dark" href="#"
                                                    role="button" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item"
                                                        href="{{ route('product.edit', ['id' => $value->id]) }}">Edit</a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('clan.add', $value->id) }}">Add Clan</a>
                                                    <a class="dropdown-item deleteData" type="button"
                                                        href="javascript:void(0)"
                                                        data-url="{{ route('product.delete', ['id' => $value->id]) }}">Delete</a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('product.priceChangeHistory', ['id' => $value->id]) }}">Price
                                                        Change History</a>
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
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).on('click', '.deleteData', function() {
            let alertMessage = "Are You Sure,You Want to Delete it"
            let routeUrl = $(this).data('url')
            deleteData(alertMessage, routeUrl)
        })
    </script>
@endpush
