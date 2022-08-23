<div class="tab-pane" id="tab-special">
    <div class="pl-lg-4 row">
        <div class="table-responsive">
            <table class="table align-items-center table-flush" id="counter_special_tbl">
                <thead class="thead-dark">
                <tr>
                    <th scope="col" class="sort" data-sort="price">Price</th>
                    <th scope="col" class="sort" data-sort="start_date">Start Date</th>
                    <th scope="col" class="sort" data-sort="end_date">End Date</th>
                </tr>
                </thead>
                <tbody class="list">
                @if($product->special)
                      <tr class="tr_special_clone">
                          <input type="hidden" name="special" value="{{ $product->special->id }}">
                          <td><input type="text" name="special_price" id="special_price0" class="form-control form-control-alternative{{ $errors->has('special_price') ? ' is-invalid' : '' }}" value="{{ old('special_price', $product->special->price) }}" ></td>
                          <td><input  name="start_date" class="form-control datepicker {{ $errors->has('start_date') ? ' is-invalid' : '' }}" placeholder="Select Start date" type="text" value="{{ old('start_date', $product->special->start_date) }}" ></td>
                          <td><input  name="end_date" class="form-control datepicker {{ $errors->has('end_date') ? ' is-invalid' : '' }}" placeholder="Select End date" type="text" value="{{ old('end_date', $product->special->end_date) }}" ></td>
                      </tr>
                  @else
                  <tr class="tr_special_clone">
                      <td><input type="text" name="special_price" id="special_price0" class="form-control form-control-alternative{{ $errors->has('special_price') ? ' is-invalid' : '' }}" value="{{ old('special_price', '') }}" ></td>
                      <td><input  name="start_date" class="form-control datepicker {{ $errors->has('start_date') ? ' is-invalid' : '' }}" placeholder="Select Start date" type="text" value="{{ old('start_date', '') }}" ></td>
                      <td><input  name="end_date" class="form-control datepicker {{ $errors->has('end_date') ? ' is-invalid' : '' }}" placeholder="Select End date" type="text" value="{{ old('end_date', '') }}" ></td>
                  </tr>
                @endif
                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>
    </div>

</div>
