<div class="pl-lg-4 row row_value_tbl">
    <div class="table-responsive">
        <table class="table align-items-center table-flush" id="tbl">
            <thead class="thead-dark">
            <tr>
                <th scope="col" class="sort" data-sort="option_value_name">Option Value Name</th>
                <th scope="col" class="sort" data-sort="status">Image</th>
                <th scope="col" class="sort" data-sort="sort_order">Sort Order</th>
            </tr>
            </thead>
            <tbody class="list">
            <tr class="tr_clone">
                <td><input type="text" name="option_value[name][]" id="name0" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name', '') }}" required></td>
                <td><input type="file" name="option_value[image][]" id="image0" class="form-control form-control-alternative{{ $errors->has('image') ? ' is-invalid' : '' }}" value="{{ old('image', '') }}" required></td>
                <td class="budget"><input type="number" min="1" name="option_value[sort_order][]" id="sort_order0" value="{{ old('sort_order_image', '') }}" class="form-control form-control-alternative{{ $errors->has('sort_order') ? ' is-invalid' : '' }}" required></td>
                <td>
                    <button class="btn btn-danger" id="DeleteButton" ><icon class="fa fa-minus" /></button>
                </td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <td style="text-align:right" colspan="5">
                    <button type="button" class="btn btn-primary " id="addRowButton" ><icon class="fa fa-plus" /></button>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
