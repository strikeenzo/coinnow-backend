<div class="tab-pane " id="tab-data">

    <div class="row">
        <div class="col-md-6 form-group{{ $errors->has('model') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="model">{{ __('Model') }}*</label>
            <input type="text" name="model" id="model"
                class="form-control form-control-alternative{{ $errors->has('model') ? ' is-invalid' : '' }}"
                placeholder="{{ __('Model') }}" value="{{ old('model', $product->model) }}">

            @if ($errors->has('model'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('model') }}</strong>
                </span>
            @endif
        </div>

    </div>

    <div class="row">
        <div class="col-md-6 form-group{{ $errors->has('min_price') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="min_price">{{ __('Min Price') }}*</label>
            <input type="text" name="min_price" id="min_price"
                class="form-control form-control-alternative{{ $errors->has('min_price') ? ' is-invalid' : '' }}"
                placeholder="{{ __('Min Price') }}" value="{{ old('min_price', $product->min_price) }}">

            @if ($errors->has('min_price'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('min_price') }}</strong>
                </span>
            @endif
        </div>

        <div class="col-md-6 form-group{{ $errors->has('max_price') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="max_price">{{ __('Max Price') }}*</label>
            <input type="number" name="max_price" id="max_price"
                class="form-control form-control-alternative{{ $errors->has('max_price') ? ' is-invalid' : '' }}"
                placeholder="{{ __('Max Price') }}" value="{{ old('max_price', $product->max_price) }}">

            @if ($errors->has('max_price'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('max_price') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 form-group{{ $errors->has('quantity') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-name">{{ __('Quantity') }}*</label>
            <input type="number" min="0" name="quantity" id="quantity"
                value="{{ old('quantity', $product->quantity) }}"
                class="form-control form-control-alternative{{ $errors->has('quantity') ? ' is-invalid' : '' }}">
            @if ($errors->has('quantity'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('quantity') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-md-6 form-group{{ $errors->has('range_quantity') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-name">{{ __('range_Quantity') }}*</label>
            <input type="number" min="0" name="range_quantity" id="range_quantity"
                value="{{ old('range_quantity', $product->range_quantity) }}"
                class="form-control form-control-alternative{{ $errors->has('range_quantity') ? ' is-invalid' : '' }}"
                required>
            @if ($errors->has('range_quantity'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('range_quantity') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-md-6 form-group {{ $errors->has('tax_rate_id') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="tax_rate_id">{{ __('Tax Rate') }}</label>
            <select class="form-control {{ $errors->has('tax_rate_id') ? ' has-danger' : '' }}" name="tax_rate_id">
                <option value="">Select </option>
                @foreach ($data['tax_rate'] as $key => $value)
                    <option value="{{ $key }}" {{ $product->tax_rate_id == $key ? 'selected' : '' }}>
                        {{ $value }}</option>
                @endforeach
            </select>
            @if ($errors->has('tax_rate_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('tax_rate_id') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-md-6 form-group{{ $errors->has('auto_stock_amount') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-name">{{ __('auto_stock_amount') }}*</label>
            <input type="number" min="0" name="auto_stock_amount" id="auto_stock_amount"
                value="{{ old('auto_stock_amount', $product->auto_stock_amount) }}"
                class="form-control form-control-alternative{{ $errors->has('auto_stock_amount') ? ' is-invalid' : '' }}"
                required>
            @if ($errors->has('auto_stock_amount'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('auto_stock_amount') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 form-group{{ $errors->has('points') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-name">{{ __('Power Impact') }}*</label>
            <input type="number" min="0" name="points" id="points"
                value="{{ old('points', $product->points ?? 0) ?? 0 }}"
                class="form-control form-control-alternative{{ $errors->has('points') ? ' is-invalid' : '' }}">
            @if ($errors->has('points'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('points') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-md-6 form-group{{ $errors->has('amount') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-name">{{ __('Amount For News') }}*</label>
            <input type="number" min="0" name="amount" id="amount"
                value="{{ old('amount', $product->amount ?? 0) }}"
                class="form-control form-control-alternative{{ $errors->has('amount') ? ' is-invalid' : '' }}">
            @if ($errors->has('amount'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('amount') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-md-6 form-group{{ $errors->has('power') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-name">{{ __('Power Required') }}*</label>
            <input type="number" min="0" name="power" id="power"
                value="{{ old('power', $product->power ?? 0) }}"
                class="form-control form-control-alternative{{ $errors->has('power') ? ' is-invalid' : '' }}">
            @if ($errors->has('power'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('power') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-md-6 form-group{{ $errors->has('change_amount') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-name">{{ __('Price Change Amount') }}*</label>
            <input type="number" min="0" name="change_amount" id="change_amount"
                value="{{ old('change_amount', $product->change_amount ?? 0) }}"
                class="form-control form-control-alternative{{ $errors->has('change_amount') ? ' is-invalid' : '' }}">
            @if ($errors->has('change_amount'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('change_amount') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <h3>Product Dimension</h3><br>
    <div class="row">
        <div class="col-md-4 form-group{{ $errors->has('length') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="length">{{ __('Length') }}</label>
            <input type="text" name="length" id="length"
                class="form-control form-control-alternative{{ $errors->has('length') ? ' is-invalid' : '' }}"
                placeholder="{{ __('Length') }}" value="{{ old('length', $product->length) }}">

            @if ($errors->has('length'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('length') }}</strong>
                </span>
            @endif
        </div>

        <div class="col-md-4 form-group{{ $errors->has('width') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="width">{{ __('Width') }}</label>
            <input type="text" name="width" id="width"
                class="form-control form-control-alternative{{ $errors->has('width') ? ' is-invalid' : '' }}"
                placeholder="{{ __('Width') }}" value="{{ old('width', $product->width) }}">

            @if ($errors->has('width'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('width') }}</strong>
                </span>
            @endif
        </div>

        <div class="col-md-4 form-group{{ $errors->has('height') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="height">{{ __('Height') }}</label>
            <input type="text" name="height" id="height"
                class="form-control form-control-alternative{{ $errors->has('height') ? ' is-invalid' : '' }}"
                placeholder="{{ __('Height') }}" value="{{ old('height', $product->height) }}">

            @if ($errors->has('height'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('height') }}</strong>
                </span>
            @endif
        </div>
    </div>


    <div class="row">
        <div class="col-md-4 form-group{{ $errors->has('weight_class_id') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="weight_class_id">{{ __('Weight Class') }}</label>
            <select class="form-control" name="weight_class_id">
                <option value="">Select</option>
                @foreach ($data['weight_class'] as $key => $value)
                    <option value="{{ $key }}" {{ $product->weight_class_id == $key ? 'selected' : '' }}>
                        {{ $value }}</option>
                @endforeach
            </select>
            @if ($errors->has('weight_class_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('weight_class_id') }}</strong>
                </span>
            @endif
        </div>

        <div class="col-md-4 form-group{{ $errors->has('weight') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="weight">{{ __('Weight') }}</label>
            <input type="text" name="weight" id="weight"
                class="form-control form-control-alternative{{ $errors->has('weight') ? ' is-invalid' : '' }}"
                placeholder="{{ __('Weight') }}" value="{{ old('weight', $product->weight) }}">

            @if ($errors->has('weight'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('weight') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-md-4  form-group{{ $errors->has('date_available') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="date_available">{{ __('AvaiLabel Date') }}</label>
            <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                </div>
                <input name="date_available"
                    class="form-control datepicker {{ $errors->has('date_available') ? ' is-invalid' : '' }}"
                    placeholder="Select date" type="text"
                    value="{{ old('date_available', $product->date_available) }}" autofocus>
                @if ($errors->has('date_available'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('date_available') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 form-group{{ $errors->has('stock_status_id') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="stock_status_id">{{ __('Stock Status') }}</label>
            <select class="form-control" name="stock_status_id">
                <option value="">Select</option>
                @foreach ($data['stock_status'] as $key => $value)
                    <option value="{{ $key }}" {{ $product->stock_status_id == $key ? 'selected' : '' }}>
                        {{ $value }}</option>
                @endforeach
            </select>
            @if ($errors->has('stock_status_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('stock_status_id') }}</strong>
                </span>
            @endif
        </div>



        <div class="col-md-4 form-group{{ $errors->has('status') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="status">{{ __('Status') }}</label>
            <select class="form-control" name="status">
                @foreach (config('constant.status') as $key => $value)
                    <option value={{ $key }} {{ $product->status == $key ? 'selected' : '' }}>
                        {{ $value }}</option>
                @endforeach
            </select>
            @if ($errors->has('status'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('status') }}</strong>
                </span>
            @endif
        </div>

        <div class="col-md-4 form-group{{ $errors->has('sort_order') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-name">{{ __('Sort Order') }}</label>
            <input type="number" min="0" name="sort_order" id="sort_order"
                value="{{ old('sort_order', $product->sort_order) }}"
                class="form-control form-control-alternative{{ $errors->has('sort_order') ? ' is-invalid' : '' }}">
            @if ($errors->has('sort_order'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('sort_order') }}</strong>
                </span>
            @endif
        </div>
    </div>




</div>
