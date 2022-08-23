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
                <tr class="tr_clone">
                    <td><input type="file" name="product_image[image][]" id="image0" class="form-control form-control-alternative{{ $errors->has('image') ? ' is-invalid' : '' }}" value="{{ old('image', '') }}" ></td>
                    <td class="budget"> <input type="number" min="1" name="product_image[sort_order_image][]" id="sort_order_image0" value="{{ old('sort_order_image', '') }}" class="form-control form-control-alternative{{ $errors->has('sort_order_image') ? ' is-invalid' : '' }}"  autofocus></td>
                    <td>
                        <button class="btn btn-danger" type="button" id="DeleteButton" ><icon class="fa fa-minus" /></button>
                    </td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <td style="text-align:right" colspan="5">
                        <button type="button" class="btn btn-primary addRowButton" id="addRowButton" ><icon class="fa fa-plus" /></button>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
