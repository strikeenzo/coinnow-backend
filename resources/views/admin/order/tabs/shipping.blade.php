<div class="tab-pane" id="tab-shipping">
    <div class="pl-lg-4 row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="shipping_firstname" class="control-label">First Name</label>
                <input type="text" name="shipping_firstname" id="shipping_firstname" value="{{ isset($order->shipping_firstname) ? $order->shipping_firstname : '' }}" class="form-control" />
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="shipping_lastname" class="control-label">Last Name</label>
                <input type="text" name="shipping_lastname" id="shipping_lastname" value="{{ isset($order->shipping_lastname) ? $order->shipping_lastname : '' }}" class="form-control" />
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="shipping_company" class="control-label">Company</label>
                <input type="text" name="shipping_company"  id="shipping_company" value="{{ isset($order->shipping_company) ? $order->shipping_company : '' }}" class="form-control" />
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="shipping_address_1" class="control-label">Address 1</label>
                <input type="text" name="shipping_address_1"  id="shipping_address_1" value="{{ isset($order->shipping_address_1) ? $order->shipping_address_1 : '' }}" class="form-control" />
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="shipping_address_2" class="control-label">Address 2</label>
                <input type="text" name="shipping_address_2"  id="shipping_address_2" value="{{ isset($order->shipping_address_2) ? $order->shipping_address_2 : '' }}" class="form-control" />
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="shipping_city" class="control-label">City</label>
                <input type="text" name="shipping_city"  id="shipping_city" value="{{ isset($order->shipping_city) ? $order->shipping_city : '' }}" class="form-control" />
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="shipping_postcode" class="control-label">PostCode</label>
                <input type="text" name="shipping_postcode"  id="shipping_postcode" value="{{ isset($order->shipping_postcode) ? $order->shipping_postcode : '' }}" class="form-control" />
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label" for="shipping_country_id">{{ __('Country') }}</label>
                <select class="form-control" id="shipping_country_id" name="shipping_country_id">
                    <option value="">Select Counry</option>
                    @foreach($data['country'] as $key => $value )
                        <option value={{ $key }} {{ isset($order->shipping_country_id) && $order->shipping_country_id == $key ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
