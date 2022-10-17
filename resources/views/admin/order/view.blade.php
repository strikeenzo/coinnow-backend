@extends('admin.layouts.app')

@section('content')
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-black d-inline-block">Order Detail</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href={{ route('dashboard') }}><i class="fas fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('order') }}">Order Detail</a></li>
                            </ol>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </div>




    <!-- Page content -->
    <div class="container-fluid ">
        <div class="row">
            <div class="col">
                <div class="card p-3">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-shopping-cart"></i> Order Details</h3>
                            </div>
                            <hr>
                            <p class="lefttxt"><button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
                                    data-original-title="Order Date"><i class="fa fa-calendar fa-fw"></i></button> <span
                                    class="rightTxt">{{ date('d M Y  ', strtotime($order->order_date)) }}</span> </p>
                            <p class="lefttxt"><button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
                                    data-original-title="Payment Method"><i class="fa fa-credit-card fa-fw"></i></button>
                                <span class="rightTxt">{{ $order->payment_method }}</span> </p>
                            <p class="lefttxt"><button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
                                    data-original-title="Shipping Method" aria-describedby="tooltip199408"><i
                                        class="fa fa-truck fa-fw"></i></button> <span
                                    class="rightTxt">{{ $order->shipping_name }}</span> </p>
                        </div>

                        <div class="col-md-4">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-user"></i> Customer Details</h3>
                            </div>
                            <hr>
                            <p class="lefttxt"><button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
                                    data-original-title="Customer" aria-describedby="tooltip202303"><i
                                        class="fa fa-user fa-fw"></i></button> <span
                                    class="rightTxt">{{ $order->firstname }} {{ $order->lastname }}</span> </p>
                            <p class="lefttxt"><button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
                                    data-original-title="E-Mail" aria-describedby="tooltip948203"><i
                                        class="fa fa-envelope fa-fw"></i></button> <span
                                    class="rightTxt">{{ $order->email }}</span> </p>
                            <p class="lefttxt"><button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
                                    data-original-title="Telephone" aria-describedby="tooltip751418"><i
                                        class="fa fa-phone fa-fw"></i></button> <span
                                    class="rightTxt">{{ $order->telephone }}</span> </p>
                        </div>

                        <div class="col-md-4">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-truck"></i> Shipping Address</h3>
                            </div>
                            <hr>
                            <p class="lefttxt">{{ $order->shipping_address_1 }}</p>
                            <p class="lefttxt">{{ $order->shipping_address_2 . ', ' }}{{ $order->shipping_city }}</p>
                            <p class="lefttxt">
                                {{ $order->orderCountry ? $order->orderCountry->name . ', ' : null }}{{ $order->shipping_postcode }}
                            </p>
                        </div>
                    </div>
                    <hr>
                    <h3 class="mt-1">Add Order History</h3>
                    <div class="row  p-1">
                        <div class="col-md-4 form-group }}">
                            <form class="" action="{{ route('order.updateStatus', ['id' => $order->id]) }}"
                                method="post">
                                @csrf
                                <label class="form-control-label" for="group_id">{{ __('Order Status') }}</label>
                                <select class="form-control" name="order_status_id">
                                    @foreach ($orderStatus as $key => $value)
                                        <option value={{ $value->id }}
                                            @if ($value->id == $order->order_status_id) selected="true" @endif>{{ $value->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-group mt-3">
                                    <label for="comment" class="control-label">Comment</label>
                                    <textarea name="comment" rows="3" id="comment" class="form-control" required="true"></textarea>
                                </div>
                                <button type="submit" class="btn btn-warning mb-3 mt-3">Update Order Status</button>
                            </form>

                        </div>
                        <div class="col-md-8">
                            <h4>Order History</h4>
                            <div class="" style=" height:200px;
  overflow-y: scroll;">
                                <ul class="list-group list-group-flush">
                                    @foreach ($orderHistory as $history)
                                        <li class="list-group-item-light mb-1">
                                            {{ date('d M Y  ', strtotime($history->created_at)) }} -
                                            {{ $history->comment }}</li>
                                    @endforeach
                                </ul>
                            </div>

                        </div>
                    </div>
                    <div class="row  p-3 table-responsive">
                        <h3>Order Products</h3>
                        <table class="table  table-light ">
                            <thead>
                                <th>Product</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </thead>
                            <tbody>
                                @php
                                    $subTotal = 0;
                                    $grandTotal = 0;
                                @endphp
                                @foreach ($orderProducts as $product)
                                    <tr>
                                        <td class="budget">
                                            @if ($product->image)
                                                <img src="{{ asset('/public/uploads/product') . '/' . $product->image }}"
                                                    alt="{{ $product->name }}" class="img-thumbnail img-fluid"
                                                    style=" width: 60px;height: 60px;">
                                            @else
                                                <img src="{{ asset('/assets/img/default.png') }}"
                                                    alt="{{ $product->name }}" class="img-thumbnail img-fluid"
                                                    style=" width: 60px;height: 60px;">
                                            @endif
                                        </td>
                                        <td><a
                                                href=href="{{ route('product.edit', ['id' => $product->product_id]) }}">{{ $product->name }}</a>
                                        </td>
                                        <td>{{ $product->quantity }}</td>
                                        <td>${{ number_format($product->total, 2) }}</td>
                                        <td>${{ number_format($product->total * $product->quantity, 2) }}</td>
                                    </tr>
                                    @php$subTotal += $product->total * $product->quantity;
                                        $grandTotal += $subTotal;
                                    @endphp
                                @endforeach
                                <tr>
                                    <td colspan="4" align="right">Sub-Total</td>
                                    <td colspan="4"><b>${{ $subTotal }}</b> </td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="right">Shipping Charge</td>
                                    <td colspan="4"><b>${{ number_format($order->shipping_charge, 2) }}</b> </td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="right">Tax</td>
                                    <td colspan="4"><b>${{ number_format($order->tax_amount, 2) }}</b> </td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="right">Discount</td>
                                    <td colspan="4"><b>${{ number_format($order->discount, 2) }}</b> </td>
                                </tr>
                                @php
                                    $grandTotal += $order->shipping_charge + $order->tax_amount - $order->discount;
                                @endphp
                                <tr>
                                    <td colspan="4" align="right">Grand Total</td>
                                    <td colspan="4"><b>${{ number_format($grandTotal, 2) }}</b> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
<style media="screen">
    .lefttxt {
        font-size: 14px;
        color: #32325d;
        line-height: 10px;
        font-weight: 500;
    }

    .rightTxt {
        font-size: 14px;
        color: #32325d;
        line-height: 10px;
        font-weight: 600;
    }

    .panel-heading {
        color: #4c4d5a;
        border-color: #dcdcdc;
        background: #f6f6f6;
        text-shadow: 0 -1px 0 rgb(50 50 50 / 0%);
        padding: 12px 15px;
        border-bottom: 1px solid transparent;
        border-top-right-radius: 2px;
        border-top-left-radius: 2px;
        text-align: center;
    }

    .panel-title : {
        margin-top: 0;
        margin-bottom: 0;
        font-size: 15px;
        text-align: center;
        vertical-align: center
    }
</style>
