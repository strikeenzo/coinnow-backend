<div class="tab-pane" id="tab-special">

    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table align-items-center table-flush" >
                <thead class="thead-dark">
                <tr>
                    <th scope="col" class="sort" data-sort="price">Price</th>
                    <th scope="col" class="sort" data-sort="start_date">Start Date</th>
                    <th scope="col" class="sort" data-sort="end_date">End Date</th>
                </tr>
                </thead>
                <tbody class="list">
                <tr class="tr_special_clone">
                    <td><input type="text" name="special_price" id="special_price" class="form-control form-control-alternative{{ $errors->has('special_price') ? ' is-invalid' : '' }}" value="{{ old('special_price', '') }}" ></td>
                    <td><input  name="start_date" class="form-control datepicker {{ $errors->has('start_date') ? ' is-invalid' : '' }}" placeholder="Select Start date" type="text" value="{{ old('start_date', '') }}"  ></td>
                    <td><input  name="end_date" class="form-control datepicker {{ $errors->has('end_date') ? ' is-invalid' : '' }}" placeholder="Select End date" type="text" value="{{ old('end_date', '') }}"  ></td>
                </tr>
                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>
    </div>

</div>
