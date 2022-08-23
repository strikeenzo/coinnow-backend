<div class="tab-pane" id="tab-product">
    <div class="pl-lg-4 row">
        <h3>Products</h3>
        <div class="table-responsive">
            <table class="table align-items-center table-flush" id="product_tbl">
                <thead class="thead-dark">
                <tr>
                    <th scope="col" class="sort" data-sort="price">Product</th>
                    <th scope="col" class="sort" data-sort="quantity">Model</th>
                    <th scope="col" class="sort" data-sort="start_date">Quantity</th>
                    <th scope="col" class="sort" data-sort="unit_price">Unit Price</th>
                    <th scope="col" class="sort" data-sort="product_total">Total</th>
                    <th scope="col" class="sort" data-sort="product_action">Action</th>
                </tr>
                </thead>
                <tbody class="list">
                </tbody>
            </table>
        </div>
    </div>
    <hr>
    <div class="pl-lg-4 row">
        <div class="col-md-5 form-group">
            <label for="product_ids" class="control-label">Choose Product</label>
            <div class="">
                <select class="form-control"  id="product_id" name="productId">
                    <option value="">Select Customer</option>
                    @foreach($data['products'] as $key => $value )
                        <option value={{ $key }}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-5 form-group">
            <label for="quantity0" class="control-label">Quantity</label>
            <div class="">
                <input type="number" name="productQuantity" min="1" max=50 id="product_quantity" class="form-control" />
            </div>
        </div>
        <div class="col-md-2">
            <label for="" class="control-label"></label><br>
            <button type="button" class="btn btn-primary " id="addProductRowButton" ><icon class="fa fa-plus" /> Click to add product</button>
        </div>
    </div>
</div>
