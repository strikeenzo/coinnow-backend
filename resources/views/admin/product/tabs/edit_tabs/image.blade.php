<div class="tab-pane" id="tab-image">
    <div class="pl-lg-4 row">
        <div class="table-responsive">
            <table class="table align-items-center table-flush" id="tbl">
                <thead class="thead-dark">
                <tr>
                    <th scope="col" class="sort" data-sort="status">Image</th>
                    <th scope="col" class="sort" data-sort="status">Sort Order</th>
                </tr>
                </thead>
                <tbody class="list">

                @forelse($product->images as $key => $value)
                    <tr class="tr_clone">
                        <input type="hidden" name="product_image[id][]" value="{{ $value->id }}">
                        <td>
                            <input type="file" name="product_image[image][]" id="image{{$key}}" class="form-control form-control-alternative{{ $errors->has('image') ? ' is-invalid' : '' }}" value="{{$value->image}}">
                            <a target="_blank" href="{{ url(config('constant.file_path.product')."/$value->image") }}">View Image</a>
                        </td>
                        <td class="budget"> <input type="number" min="1" name="product_image[sort_order_image][]" id="sort_order_image0" value="{{ old('sort_order_image', $value->sort_order_image) }}" class="form-control form-control-alternative{{ $errors->has('sort_order_image') ? ' is-invalid' : '' }}" ></td>
                        <td>
                            <button class="btn btn-danger" type="button" id="DeleteButton" ><icon class="fa fa-minus" /></button>
                        </td>
                    </tr>
                @empty
                    <tr class="tr_clone">
                        <td><input type="file" name="product_image[image][]" id="image0" class="form-control form-control-alternative{{ $errors->has('image') ? ' is-invalid' : '' }}" value="{{ old('image', '') }}" ></td>
                        <td class="budget"> <input type="number" min="1" name="product_image[sort_order_image][]" id="sort_order_image0" value="{{ old('sort_order_image', '') }}" class="form-control form-control-alternative{{ $errors->has('sort_order_image') ? ' is-invalid' : '' }}" ></td>
                        <td>
                            <button class="btn btn-danger" type="button" id="DeleteButton" ><icon class="fa fa-minus" /></button>
                        </td>
                    </tr>
                @endforelse
                </tbody>
                <tfoot>
                <tr>
                    <td style="text-align:right" colspan="5">
                        <button type="button" class="btn btn-primary addRowButton" ><icon class="fa fa-plus" /></button>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
