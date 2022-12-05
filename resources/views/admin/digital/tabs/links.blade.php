<div class="tab-pane " id="tab-links">
    <div class="col-md-12 form-group{{ $errors->has('category_id') ? ' has-danger' : '' }}">
        <label class="form-control-label" for="category_id">{{ __('Category') }}*</label>
        <select class="form-control" name="category_id">
            <option value="">Select</option>
            @foreach ($data['category'] as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>

        @if ($errors->has('category_id'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('category_id') }}</strong>
            </span>
        @endif
    </div>

    <div class="col-md-12 form-group{{ $errors->has('manufacturer_id') ? ' has-danger' : '' }}">
        <label class="form-control-label" for="manufacturer_id">{{ __('Manufacturer') }}</label>
        <select class="form-control" name="manufacturer_id">
            <option value="">Select</option>
            @foreach ($data['manufacturer'] as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
        @if ($errors->has('manufacturer_id'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('manufacturer_id') }}</strong>
            </span>
        @endif
    </div>

    <div class="col-md-12 form-group{{ $errors->has('related_id') ? ' has-danger' : '' }}">
        <label class="form-control-label" for="status">{{ __('Related Products') }}</label>
        <select class="form-control selectpicker" multiple data-live-search="true" name="related_id[]">
            @foreach ($data['pluckProducts'] as $key => $value)
                <option value={{ $key }}>{{ $value }}</option>
            @endforeach
        </select>

        @if ($errors->has('related_id'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('related_id') }}</strong>
            </span>
        @endif
    </div>
</div>
