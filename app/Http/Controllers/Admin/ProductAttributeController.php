<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ProductAttributeController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->get('name', '');

        $records = ProductAttribute::with('productGroup:name,id')->select('id', 'group_id', 'name', 'status')
            ->when($name != '', function ($q) use ($name) {
                $q->where('name', 'like', "%$name%")
                    ->orWhereHas('productGroup', function ($q) use ($name) {
                        $q->where('name', 'like', "%$name%");
                    });
            })->orderBy('created_at', 'DESC')->paginate($this->defaultPaginate);

        return view('admin.product_attribute.index', ['records' => $records]);
    }

    public function add()
    {
        return view('admin.product_attribute.add', [
            'productAttributeGroup' => ProductAttributeGroup::getActivePluck(),
        ]);
    }

    protected function validateData($request)
    {

//        $uniqueRuleCode = 'unique:product_attribute_groups';
//
//        if(Route::currentRouteName() == 'product-attribute-group.update') {
//            $uniqueRuleCode = 'unique:product_attribute_groups,name,'.$request->id;
//        }

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
        ]);
    }

    public function store(Request $request)
    {

        $this->validateData($request);
        $data = new ProductAttribute($request->only('name', 'group_id', 'status'));
        $data->save();

        return redirect(route('product-attribute'))->with('success', 'Product Attribute Created Successfully');
    }

    public function edit($id)
    {

        return view('admin.product_attribute.edit', [
            'data' => ProductAttribute::findOrFail($id),
            'productAttributeGroup' => ProductAttributeGroup::getActivePluck(),
        ]);
    }

    public function update(Request $request, $id)
    {

        $this->validateData($request);
        $data = ProductAttribute::findOrFail($id);
        $data->fill($request->only('name', 'group_id', 'status'))->save();

        return redirect(route('product-attribute'))->with('success', 'Product Attribute Updated Successfully');
    }

    public function delete($id)
    {
        if (!$data = ProductAttribute::whereId($id)->first()) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

        $data->delete();
        return redirect(route('product-attribute'))->with('success', 'Product Attribute  Deleted Successfully');
    }
}
