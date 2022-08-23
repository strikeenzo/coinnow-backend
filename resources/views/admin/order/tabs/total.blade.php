<div class="tab-pane" id="tab-totals">
    <div class="pl-lg-4 row">
        <h3>Products</h3>
        <div class="table-responsive">
            <table class="table align-items-center table-bordered" id="product_total_tbl">
                <thead class="thead-dark">
                <tr>
                    <th scope="col" class="sort" data-sort="price">Product</th>
                    <th scope="col" class="sort" data-sort="model">Model</th>
                    <th scope="col" class="sort" data-sort="quantity">Quantity</th>
                    <th scope="col" class="sort" data-sort="unit_price">Unit Price</th>
                    <th scope="col" class="sort" data-sort="product_total">Total</th>
                </tr>
                </thead>
                <tbody class="list">
                <tr class="tr_sub_total">
                    <td colspan="4" class="text-right">Sub-Total</td>
                    <td class="text-right" id="sub_total"></td>
                </tr>

                <tr class="tr_grand_total">
                    <td colspan="4" class="text-right">Total</td>
                    <td class="text-right" id="grand_total"></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <hr>
    <div class="pl-lg-4 row">

        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label " for="shipping_method">{{ __('Shipping Method') }}</label>
                <select class="form-control" id="shipping_method" name="shipping_method">
                    <option value="">Select </option>
                    @foreach(config('constant.shipping_method') as $key => $value )
                        <option {{ isset($order->shipping_method) && $order->shipping_method == $key ? 'selected' : '' }} value={{ $key }}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="payment_method">{{ __('Payment Method') }}</label>
                <select class="form-control" id="payment_method" name="payment_method">
                    <option value="">Select</option>
                    @foreach(config('constant.payment_method') as $key => $value )
                        <option value={{ $key }} {{ isset($order->payment_method) && $order->payment_method == $key ? 'selected' : '' }} >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="coupon_code" class="control-label">Coupon</label>
                <input type="text" name="coupon_code"  id="coupon_code" class="form-control" />
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="order_status_id">{{ __('Order Status') }}</label>
                <select class="form-control" id="order_status_id" name="order_status_id">
                    @foreach($data['order_status'] as $key => $value )
                        <option value={{ $key }}  {{ isset($order->order_status_id) && $data['order_status'][$order->order_status_id] == $key ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="comment" class="control-label">Comment</label>
                <textarea name="comment" rows="3"  id="comment" class="form-control" >{{ isset($order->order_status_id)  ? $order->comment : '' }}</textarea>
            </div>
        </div>
    </div>
</div>
