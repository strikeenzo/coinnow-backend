@extends('admin.layouts.app')

@section('content')

<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-black d-inline-block mb-0">{{ $seller->firstname }} {{ $seller->lastname }}'s History</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
              <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href={{ route('dashboard') }}><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="{{ route('seller') }}">Seller</a></li>
                  <li class="breadcrumb-item">History</li>
              </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="header bg-primary pb-6">
  <div class="container-fluid mt--6 mb--1">
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-dark">
                <tr>
                  <th>Seller</th>
                  <th>Balance</th>
                  <th>Price</th>
                  <th>Amount</th>
                  <th>Product</th>
                  <th>Type</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                @forelse($records as $key => $value)
                  <tr>
                    <td>{{ $value->seller ? $value->seller->email : "" }}</td>
                    <td>{{ $value->balance }}</td>
                    <td>{{ $value->quantity * $value->price }}</td>
                    <td>{{ $value->amount }}</td>
                    <td>{{ ($value->product ? $value->product->productDescription->name : "") }}</td>
                    <td>{{ $value->type }}</td>
                    <td>{{ $value->created_at }}</td>
                    <!-- <td>
                      {{
                        ($value->seller ? $value->seller->email : "Anyone{User Removed}")
                        .(in_array($value->type, ['item_sell', 'item_sell_auto', 'special_item_sell', 'special_item_sell_auto', 'receive_coin', 'added coins to account']) ? " earned " : " spent ").$value->price * $value->quantity." coins by ".$value->type." "
                        .$value->quantity." "
                        .($value->product ? $value->product->productDescription->name : "{Product Removed}")." items "
                        ." at ".$value->created_at
                      }}
                    </td> -->
                  </tr>
                @empty
                  <tr>
                    <td class="budget">
                      No Record Found
                    </td>
                  </tr>
                @endforelse
                  <td></td>
                </tr>
              </tbody>
            </table>
          </div>
           <!-- Card footer -->
           <div class="card-footer py-4">
              {{ $records->links() }}
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('js')
@endpush
