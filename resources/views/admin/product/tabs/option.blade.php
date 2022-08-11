<div class="tab-pane" id="tab-option">
  <input type="hidden" name="optionPost" id="optionPost" value="">

  <div class="row">

      <div class="col-md-3 mb-4 ">
        <div class="appendTab mb-3 mt-3 ">
        </div>

        <select class="form-control" name="option[type][]" onchange="setOption(this)">
            <option value="">Select Option</option>
            @foreach($data['product_options'] as $key=>$value)
              <option value="{{$value->id}}" data-label="{{$value->name}}">{{$value->name}}</option>
            @endforeach
        </select>
      </div>

        <div class="col-md-9 mb-4 " >
          <div class="table-responsive ">
          @foreach($data['product_options'] as $key=>$value)
              <table class="table align-items-center table-option table-flush d-none optionTable{{$value->id}}" data-optionID="{{$value->id}}" data-optionType="{{$value->type}}" id="counter_option_tb1{{$value->id}}" >
                  <thead>
                    <tr class="tr_option_clone">
                        <th>Label</th>
                        <th>Price</th>
                        @if($value->type == 'Color')
                          <th>Color Value</th>
                       @endif
                        <th></th>
                      </tr>
                  </thead>
                   <tbody class="list" >
                        <tr>
                          <td><input type="text" placeholder="Enter Label" name="option[{{$value->id}}][label][]" class="form-control" type="text" /></td>
                          <td><input type="number"   name="option[{{$value->id}}][price][]" class="form-control" type="text" placeholder="Enter Price" /></td>
                            @if($value->type == 'Color')
                              <td><input type="text"   name="option[{{$value->id}}][color_code][]" class="form-control" type="text" placeholder="Enter Color Name or Code" /></td>
                            @endif
                          <td>
                            <button class="btn btn-danger" type="button" id="DeleteOptionButton" ><icon class="fa fa-minus" /> </button>
                          </td>
                         </tr>

                </tr>
              </tbody>
            <tfoot>
              <tr>
                <td style="text-align:left" colspan="2">
                    <button type="button" class="btn btn-secondary addRowButton" id="addRowButton" ><icon class="fa fa-plus" /> Add Raw</button>
                </td>
            </tr>
            </tfoot>
        </table>
        @endforeach
        </div>
       </div>
    </div>

</div>
