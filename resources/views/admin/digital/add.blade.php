@extends('admin.layouts.app')

@prepend('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endprepend
@section('content')
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-black d-inline-block mb-0">Digital Show</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href={{ route('dashboard') }}><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('digital') }}">Digital Show</a></li>
                                <li class="breadcrumb-item">Add</li>
                            </ol>
                        </nav>
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
                                <h3 class="mb-0">{{ __('Create') }}</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" id="data-form" action="{{ route('digital.store.product', $id) }}" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                @method('post')

                                <h6 class="heading-small text-muted mb-4">{{ __('Create Product ') }}</h6>
                                    @include('admin.digital.tabs.tablist')

                                <div class="tab-content tab-validate" style="margin-top:20px;">
                                    @include('admin.digital.tabs.general')
                                    @include('admin.digital.tabs.data')
                                    @include('admin.digital.tabs.links')
                                    @include('admin.digital.tabs.attribute')
                                    @include('admin.digital.tabs.special')
                                    @include('admin.digital.tabs.option')
                                    @include('admin.digital.tabs.image')
                                </div>

                                <div class="row">
                                  <div class="col-md-6 text-left d-none" id="btnPrev">
                                    <button type="button" class=" btnPrevious btn btn-default   mt-4"><i class="fas fa-angle-left"></i> {{ __('Previous') }}</button>
                                  </div>
                                  <div class="col-md-6 text-right" id="btnNxt">
                                      <button type="button" class="btnNext btn btn-lg btn-success mt-4 " >{{ __('Next') }} <i class="fas fa-angle-right"></i></button>
                                  </div>
                                  <div class="col-md-6 text-right d-none" id="btnSave">
                                      <button type="submit" class=" btn btn-success mt-4" > <i class="fas fa-save"></i> {{ __('Save') }}</button>
                                  </div>
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

    <script src="{{ asset('assets') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.1/jquery.validate.min.js"></script>
    <script src="//cdn.ckeditor.com/4.4.7/standard-all/ckeditor.js"></script>
    <script src="http://cdn.ckeditor.com/4.4.7/standard-all/adapters/jquery.js"></script>

      <!-- JavaScript -->
      <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

      <!-- CSS -->
      <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
      <!-- Default theme -->
      <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>



    <script>


    let next  =false;
    $('.btnNext').click(function(){

      var tabIdx = $('.nav-tabs > .nav-item > .active').parent().next('li').find('a').attr('data-id');
      if(tabIdx == 2) {
        var productName = $("[name='name']").val();
        if(productName == '') {
          alertify.alert('Required', 'Product Name Required', function(){  });
          next = false;
        }
        else {
          next = true
        }
      }

      if(tabIdx == 4) {
        var model = $("[name='model']").val();
        var price = $("[name='price']").val();
        var quantity = $("[name='quantity']").val();

        if(model == '') {
          alertify.alert('Required', 'Model Required', function(){  });
            next = false;
        }
        else if(price == '')
        {
          alertify.alert('Required', 'Price Required', function(){  });
            next = false;
        }
        else if(quantity == '')
        {
          alertify.alert('Required', 'Quantity Required', function(){  });
            next = false;
        }
        else {
          next = true
        }
      }

      if(tabIdx == 5) {
        var cat = $("[name='category_id']").val();
        if(cat == '') {
          alertify.alert('Required', 'Category Required', function(){  });
          next = false;
        }
        else {
          next = true
        }
      }

      if(next) {
        $('.nav-tabs > .nav-item > .active').parent().next('li').find('a').trigger('click');
      }

      if(tabIdx  > 2) {
        $('#btnPrev').removeClass('d-none')
      }
    });

    $('.btnPrevious').click(function(){
      $('.nav-tabs > .nav-item > .active').parent().prev('li').find('a').trigger('click');
      var tabIdx = $('.nav-tabs > .nav-item > .active').parent().next('li').find('a').attr('data-id');
      if(tabIdx  == 2) {
        $('#btnPrev').addClass('d-none')
      }
    });

    $(".nav-tabs a[data-toggle=tab]").on("click", function(e) {
      var idx = $(this).index('a[data-toggle="tab"]');

      if(idx == 1) {
        var productName = $("[name='name']").val();
        if(productName == '') {
            alertify.alert('Required', 'Product Name Required', function(){  });
            return false;
        }
      }

      if(idx == 2) {
        var model = $("[name='model']").val();
        var price = $("[name='price']").val();
        var quantity = $("[name='quantity']").val();

        if(model == '') {
          alertify.alert('Required', 'Model Required', function(){  });
          return false;
        }
        else if(price == '')
        {
          alertify.alert('Required', 'Price Required', function(){  });
          return false;
        }
        else if(quantity == '')
        {
          alertify.alert('Required', 'Quantity Required', function(){  });
          return false;
        }

      }

      if(idx == 3) {
        var cat = $("[name='category_id']").val();
        if(cat == '') {
          alertify.alert('Required', 'Category Required', function(){  });
          return false;
        }
      }


      if(idx == 1) {
        var productName = $("[name='name']").val();
        if(productName == '') {
          $('.alert').alert()
        }
      }

      if(idx  > 0) {
        $('#btnPrev').removeClass('d-none')
      }
      if(idx  == 0) {
        $('#btnPrev').addClass('d-none')
      }
      if(idx == 6) {
        $('#btnNxt').addClass('d-none');
        $('#btnSave').removeClass('d-none');
      }
      else {
        $('#btnNxt').removeClass('d-none');
        $('#btnSave').addClass('d-none');
      }

    });

        $('.datepicker').datepicker({
            format: datePickerFormat,
            startDate: '-3d'
        });

        $('selectpicker').selectpicker();

        // Initialize select2
        $(".select2Class").select2();


        var counter = 1;
        $(document).on('click', '#addRowButton', function() {

        });

        function appendToImageTable(tableId) {
            $(`#${tableId}`).append(`<tr class="tr_clone">
            <td><input type="file" name="product_image[image][]" id=image${counter} class="form-control form-control-alternative" required></td>
            <td class="budget"> <input type="number" min="1" name="product_image[sort_order_image][]" id=sort_order_image${counter} class="form-control form-control-alternative" required autofocus></td>
            <td>
                <button class="btn btn-danger" type="button" id="DeleteButton" ><icon class="fa fa-minus" /></button>
            </td>
        </tr>`);
            counter += 1;
        }

        $("#tbl").on("click", "#DeleteButton", function() {
            $(this).closest("tr").remove();
            counter -= 1;
        });

        // Option Product
        var counter_option = 1;

        function appendToOptionTable(tableId,optionID,optionType) {

          let renderHTML = '<tr class="tr_option_clone"><td><input type="text" placeholder="Enter Label" name="option['+optionID+'][label][]" class="form-control" type="text" /></td>';
          renderHTML += '<td><input type="number"   name="option['+optionID+'][price][]" class="form-control" type="text" placeholder="Enter Price" /></td>';
          if(optionType == 'Color') {
              renderHTML += '<td><input type="text" placeholder="Enter Color Name or Code" name="option['+optionID+'][color_code][]" class="form-control" type="text" /></td>';
          }
          renderHTML += '<td><button class="btn btn-danger" type="button" type="button" id="DeleteOptionButton" ><icon class="fa fa-minus" /></button>  </td></tr>'

            $('#counter_option_tb1'+ optionID).append(renderHTML);

            counter_option += 1;

            $('.datepicker').datepicker({
                format: datePickerFormat,
                startDate: '-3d'
            });
        }

        $(document).on('click', '.addRowButton', function() {
            let tableId = $(this).closest('table').attr('id');
            let optionID = $(this).closest('table').attr('data-optionID');
            let optionType = $(this).closest('table').attr('data-optionType');

            if(tableId == 'counter_option_tb1'+optionID) {
              appendToOptionTable(tableId,optionID,optionType)
            }
            if(tableId == 'counter_attribute_tbl') {
                appendToAttributeTable(tableId)
            }
            if(tableId == 'tbl') {
                appendToImageTable(tableId)
            }

        });

        $(document).on('click', '#DeleteOptionButton', function() {
          let tableId = $(this).closest('table').attr('id');
          $(this).closest("tr").remove();
          counter_option -= 1;
        });



        // $(document).on('click', '.addRowButton', function() {
        //
        //     let tableId = $(this).closest('table').attr('id');
        //     // $('#counter_special_tbl').append();
        //     if(tableId == 'counter_special_tbl') {
        //         appendToSpecialTable(tableId)
        //     }
        //
        //     if(tableId == 'counter_attribute_tbl') {
        //         appendToAttributeTable(tableId)
        //     }
        //
        //     if(tableId == 'counter_discount_tbl') {
        //         appendToDiscountTable(tableId)
        //     }
        //
        //     if(tableId == 'tbl') {
        //         appendToImageTable(tableId)
        //     }
        //
        // });


        // Attribute Product
        var counter_attribute = 1;
        function appendToAttributeTable(tableId) {
            $(`#${tableId}`).append(`<tr class="tr_attribute_clone">
                                        <td><select class="form-control select2" name="attributesArray[${counter_attribute}][attribute_id]">
                                                @foreach($data['attributeArray'] as $key => $value)
                                                    <optgroup label="{{ $value->name }}">
                                                        @foreach($value->relationAttributes as $key1 => $value1)
                                                            <option value={{ $value1->id }}>{{ $value1->name }}</option>
                                                        @endforeach
                                                    </optgroup>
                                                @endforeach
                                            </select></td>
                                        <td><textarea class="form-control" name="attributesArray[${counter_attribute}][text]" id="attribute_text_${counter_attribute}"  rows="4"></textarea></td>
                                        <td><button class="btn btn-danger" type="button" id="DeleteAttributeButton" ><icon class="fa fa-minus" /></button></td>
                                        </tr>`);

            counter_attribute += 1;
            $(".select2").select2();
        }

      $("#counter_attribute_tbl").on("click", "#DeleteAttributeButton", function() {
          $(this).closest("tr").remove();
          counter_attribute -= 1;
      });

      var optionArr = [];

      //add dynamic tab1$(document).ready(function() {
      function setOption(val) {

        if($(val).val() != '') {
          var addOption = false;
          if(optionArr.length == 0) {
            addOption = true;
            optionArr.push($(val).val())
          }
          else {
            if(!optionArr.includes($(val).val())) {
              addOption = true;
              optionArr.push($(val).val())
            }
          }

          let postID = optionArr.join(",");
          $('#optionPost').val(postID)
          if(addOption) {
            $(".appendTab button").each(function(){
              $(this).removeClass("btn-primary");
            });

            $(".table-option").each(function(){
              $(this).addClass("d-none");
            });
            $('.appendTab').append('<button type="button" onclick="optionClick(' +$(val).val()+')" class="btn btn-primary" id="btn'+$(val).val()+'" ><span style="margin-right:10px;" onclick="removeOption('+$(val).val()+')"> <i class="fas fa-minus-square"></i> </span> '+$(val).find('option:selected').text()+'</button></br>')
            $('.optionTable'+$(val).val()).removeClass('d-none');
            $('.optionTable'+$(val).val()).show();
          }
        }

      }

      function optionClick(id) {
        $(".appendTab button").each(function(){
          $(this).removeClass("btn-primary");
        });
        $(".table-option").each(function(){
          $(this).addClass("d-none");
        });
        $('#btn'+id).addClass('btn-primary');
        $('.optionTable'+id).removeClass('d-none');

      }

      function removeOption(id) {
          $('.optionTable'+id+' > tbody').find("tr:gt(0)").empty();
          $('.optionTable'+id).hide();
          optionArr = optionArr.filter((value)=>value!=id);
          let postID = optionArr.join(",");
          $('#btn'+id).remove();
          $('#optionPost').val(postID)

      }


          $(document).ready(function () {
              $('.ckeditor').ckeditor();
          });
    </script>
@endpush
