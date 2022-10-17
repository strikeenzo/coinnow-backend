@extends('admin.layouts.app')

@section('content')
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-black d-inline-block mb-0">Banner</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href={{ route('dashboard') }}><i class="fas fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('banner') }}">Banner</a></li>
                                <li class="breadcrumb-item">Edit</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <a href="{{ route('banner.add') }}" class="btn btn-lg btn-neutral fade-class"><i
                                class="fas fa-plus fa-lg"></i> New</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="mb-0">{{ __('Edit') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('banner.update', ['id' => $data->id]) }}"
                            enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            @method('post')

                            <h6 class="heading-small text-muted mb-4">{{ __('Edit Banner ') }}</h6>

                            <div class="pl-lg-4 row">
                                <div class="col-md-6 form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                    <input type="text" name="name" id="input-name"
                                        class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Name') }}" value="{{ old('name', $data->name) }}" autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-6 form-group{{ $errors->has('status') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="status">{{ __('Status') }}</label>
                                    <select class="form-control" name="status">
                                        @foreach (config('constant.status') as $key => $value)
                                            <option value={{ $key }}
                                                {{ $data->status == $key ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('status'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('status') }}</strong>
                                        </span>
                                    @endif
                                </div>

                            </div>

                            <div class="pl-lg-4 row">

                                <div class="table-responsive">
                                    <table class="table align-items-center table-flush" id="tbl">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col" class="sort" data-sort="name">Title</th>
                                                <th scope="col" class="sort" data-sort="parent_id">Link</th>
                                                <th scope="col" class="sort" data-sort="status">Image</th>
                                                <th scope="col" class="sort" data-sort="status">Sort Order</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list">
                                            @forelse($data->images as $key => $value)
                                                <tr class="tr_clone">
                                                    <td class="budget">
                                                        <input type="hidden" name="ids[]" value="{{ $value->id }}">
                                                        <input type="text" name="title[]" id="title{{ $key }}"
                                                            class="form-control form-control-alternative{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                                            placeholder="{{ __('Title') }}"
                                                            value="{{ old('title', $value->title) }}" required autofocus>
                                                    </td>
                                                    <td class="budget"><input type="text" name="link[]"
                                                            id="link{{ $key }}"
                                                            class="form-control form-control-alternative{{ $errors->has('link') ? ' is-invalid' : '' }}"
                                                            placeholder="{{ __('Link') }}"
                                                            value="{{ old('link', $value->link) }}" required autofocus>
                                                    </td>
                                                    <td>
                                                        <input type="file" name="image[]" id="image{{ $key }}"
                                                            class="form-control form-control-alternative{{ $errors->has('image') ? ' is-invalid' : '' }}"
                                                            value="{{ old('image', '') }}">
                                                        <a target="_blank"
                                                            href="{{ url(config('constant.file_path.banner') . "/$value->image") }}">View
                                                            Image</a>
                                                    </td>
                                                    <td class="budget"> <input type="number" min="1"
                                                            name="sort_order[]" id="sort_order{{ $key }}"
                                                            value="{{ old('sort_order', $value->sort_order) }}"
                                                            class="form-control form-control-alternative{{ $errors->has('sort_order') ? ' is-invalid' : '' }}"
                                                            required autofocus></td>
                                                    <td>
                                                        <button class="btn btn-danger" id="DeleteButton">
                                                            <icon class="fa fa-minus" />
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr class="tr_clone">
                                                    <td class="budget"><input type="text" name="title[]"
                                                            id="title0"
                                                            class="form-control form-control-alternative{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                                            placeholder="{{ __('Title') }}"
                                                            value="{{ old('title', '') }}" required autofocus></td>
                                                    <td class="budget"><input type="text" name="link[]"
                                                            id="link0"
                                                            class="form-control form-control-alternative{{ $errors->has('link') ? ' is-invalid' : '' }}"
                                                            placeholder="{{ __('Link') }}"
                                                            value="{{ old('link', '') }}" required autofocus></td>
                                                    <td><input type="file" name="image[]" id="image0"
                                                            class="form-control form-control-alternative{{ $errors->has('image') ? ' is-invalid' : '' }}"
                                                            value="{{ old('image', '') }}" required></td>
                                                    <td class="budget"> <input type="number" min="1"
                                                            name="sort_order[]" id="sort_order0"
                                                            value="{{ old('sort_order', '') }}"
                                                            class="form-control form-control-alternative{{ $errors->has('sort_order') ? ' is-invalid' : '' }}"
                                                            required autofocus></td>
                                                    <td>
                                                        <button class="btn btn-danger" id="DeleteButton">
                                                            <icon class="fa fa-minus" />
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforelse

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td style="text-align:right" colspan="5">
                                                    <button type="button" class="btn btn-primary " id="addRowButton">
                                                        <icon class="fa fa-plus" />
                                                    </button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                    <a href="{{ route('banner') }}" type="button"
                                        class="btn btn-danger mt-4">{{ __('Cancel') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        var counter = 1;
        $(document).on('click', '#addRowButton', function() {
            $('#tbl').append(`<tr class="tr_clone">
            <td class="budget"><input type="text" name="title[]" id=title${counter} class="form-control form-control-alternative{{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="{{ __('Title') }}" required autofocus></td>
            <td class="budget"><input type="text" name="link[]" id=link${counter} class="form-control form-control-alternative{{ $errors->has('link') ? ' is-invalid' : '' }}" placeholder="{{ __('Link') }}"  required autofocus></td>
            <td><input type="file" name="image[]" id=image${counter} class="form-control form-control-alternative{{ $errors->has('image') ? ' is-invalid' : '' }}" required></td>
            <td class="budget"> <input type="number" min="1" name="sort_order[]" id=sort_order${counter} class="form-control form-control-alternative{{ $errors->has('sort_order') ? ' is-invalid' : '' }}" required autofocus></td>
            <td>
                <button class="btn btn-danger" id="DeleteButton" ><icon class="fa fa-minus" /></button>
            </td>
        </tr>`);
            counter += 1;
        });

        $("#tbl").on("click", "#DeleteButton", function() {
            $(this).closest("tr").remove();
            counter -= 1;
        });
    </script>
@endpush
