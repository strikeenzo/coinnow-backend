<div class="tab-pane" id="tab-option">
  <input type="hidden" name="optionPost" id="optionPost" value="{{$data['optionCommaSeprate']}}">

  <div class="row">

      <div class="col-md-3 mb-4 ">
        <div class="appendTab mb-3 mt-3 ">
          @php $i = 0; $activeOption = 0; @endphp
            @foreach($data['options'] as $option)
              <button type="button" onclick="optionClick('{{$option->id}}')" class="btn @if($i == 0) btn-primary @endif  mb-3" id="btn{{$option->id}}" >
                <span style="margin-right:10px;" onclick="removeOption('{{$option->id}}')"> <i class="fas fa-minus-square"></i>
               </span> {{$option->name}}</button>
             </br>
             @if($i == 0)
              @php    $activeOption = $option->id; @endphp
             @endif
             @php $i++; @endphp
            @endforeach
        </div>

        <select class="form-control" name="option[type][]" onchange="setOption(this)">
            <option value="">Select Option</option>
            @foreach($data['product_options'] as $key=>$values)
              <option value="{{$values->id}}" data-label="{{$values->name}}">{{$values->name}}</option>
            @endforeach
        </select>

      </div>

        <div class="col-md-9 mb-4 " >
         <div class="table-responsive ">
          @foreach($data['product_options'] as $key=>$value)
              <table class="table align-items-center table-option table-flush @if($value->id != $activeOption)  d-none   @endif optionTable{{$value->id}}" data-optionID="{{$value->id}}" data-optionType="{{$value->type}}" id="counter_option_tb1{{$value->id}}" >
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
                       @forelse($data['productOptions'] as $key2=>$optionValues)
                        @if($value->id == $optionValues->option_id)
                          <tr>
                            <td><input type="text" placeholder="Enter Label" name="option[{{$optionValues->option_id}}][label][]" class="form-control" type="text" value="{{$optionValues->label}}" /></td>
                            <td><input type="number"   name="option[{{$optionValues->option_id}}][price][]" class="form-control" type="text" placeholder="Enter Price" value="{{$optionValues->price}}" /></td>
                            @if($value->type == 'Color')
                              <td><input type="text"   name="option[{{$optionValues->option_id}}][color_code][]" class="form-control" value="{{$optionValues->color_code}}" type="text" placeholder="Enter Color Name or Code" /></td>
                            @endif
                            <td>
                              <button class="btn btn-danger" type="button" id="DeleteOptionButton" ><icon class="fa fa-minus" /> </button>
                            </td>
                          </tr>
                        @endif
                      @empty
                        <tr>
                          <td><input type="text" placeholder="Enter Label" name="option[{{$value->id}}][label][]" class="form-control" type="text" /></td>
                          <td><input type="number"   name="option[{{$value->id}}][price][]" class="form-control" type="text" placeholder="Enter Price" /></td>
                          @if($value->type == 'Color')
                            <td><input type="text"   name="option[{{$value->id}}][color_code][]" class="form-control" type="text" placeholder="Enter Color Name or Code" /></td>
                          @endif
                          <td>
                            <button class="btn btn-danger" type="button" type="button" id="DeleteOptionButton" ><icon class="fa fa-minus" /> </button>
                          </td>
                         </tr>
                      @endforelse
                     </tbody>
                     <tfoot>
                       <tr>
                         <td style="text-align:left" colspan="2">
                           <button type="button" class="btn btn-secondary addRowButton"  ><icon class="fa fa-plus" /> Add Raw</button>
                         </td>
                       </tr>
                     </tfoot>
                   </table>
                 @endforeach
               </div>

       </div>
    </div>
  </div>
