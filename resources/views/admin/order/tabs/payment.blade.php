<div class="tab-pane" id="tab-payment">

    <div class="pl-lg-4 row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="payment_firstname" class="control-label">First Name</label>
                <input type="text" name="payment_firstname" id="payment_firstname" value="{{ isset($order->payment_firstname) ? $order->payment_firstname : '' }}" class="form-control" />
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="payment_lastname" class="control-label">Last Name</label>
                <input type="text" name="payment_lastname" id="payment_lastname" value="{{ isset($order->payment_lastname) ? $order->payment_lastname : '' }}" class="form-control" />
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="payment_company" class="control-label">Company</label>
                <input type="text" name="payment_company"  id="payment_company" value="{{ isset($order->payment_company) ? $order->payment_company : '' }}" class="form-control" />
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="payment_address_1" class="control-label">Address 1</label>
                <input type="text" name="payment_address_1"  id="payment_address_1" value="{{ isset($order->payment_address_1) ? $order->payment_address_1 : '' }}" class="form-control" />
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="payment_address_2" class="control-label">Address 2</label>
                <input type="text" name="payment_address_2"  id="payment_address_2" value="{{ isset($order->payment_address_2) ? $order->payment_address_2 : '' }}" class="form-control" />
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="payment_city" class="control-label">City</label>
                <input type="text" name="payment_city"  id="payment_city" value="{{ isset($order->payment_city) ? $order->payment_city : '' }}" class="form-control" />
            </div>
        </div>


        <div class="col-md-4">
            <div class="form-group">
                <label for="payment_postcode" class="control-label">PostCode</label>
                <input type="text" name="payment_postcode"  id="payment_postcode" value="{{ isset($order->payment_postcode) ? $order->payment_postcode : '' }}" class="form-control" />
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label" for="payment_country_id">{{ __('Country') }}</label>
                    <select class="form-control" id="payment_country_id" name="payment_country_id">
                        <option value="">Select Counry</option>
                        @foreach($data['country'] as $key => $value )
                            <option value={{ $key }}  {{ isset($order->payment_country_id) && $order->payment_country_id == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
            </div>
        </div>
    </div>
</div>
