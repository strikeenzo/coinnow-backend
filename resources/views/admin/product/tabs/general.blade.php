<div class="tab-pane active" id="tab-general">

    <div class="col-md-12 form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
        <label class="form-control-label" for="input-name">{{ __('Product Name') }}*</label>
        <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name', '') }}" autofocus required>

        @if ($errors->has('name'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>


    <div class="col-md-12 form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
        <label class="form-control-label" for="input-name">{{ __('Product Description') }}</label>
        <textarea name="description" id="description" class="ckeditor form-control" placeholder="{{ __('Product Description') }}" value="{{ old('description','') }}">{!! old('description','') !!}</textarea>
        @if ($errors->has('description'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('description') }}</strong>
            </span>
        @endif
    </div>

    <div class="col-md-12 form-group{{ $errors->has('main_image') ? ' has-danger' : '' }}">
        <label class="form-control-label" for="input-email">{{ __('Image') }}</label>
        <input type="file" name="main_image" id="input-email" class="form-control form-control-alternative{{ $errors->has('main_image') ? ' is-invalid' : '' }}" value="{{ old('main_image', '') }}" >

        @if ($errors->has('main_image'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('main_image') }}</strong>
            </span>
        @endif
    </div>
</div>
