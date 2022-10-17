<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductAttributeGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ProductAttributeGroupController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->get('name', '');

        $records = ProductAttributeGroup::select('id', 'name', 'status')
            ->when($name != '', function ($q) use ($name) {
                $q->where('name', 'like', "%$name%");
            })->orderBy('created_at', 'DESC')->paginate($this->defaultPaginate);
        return view('admin.product_attribute_group.index', ['records' => $records]);
    }

    public function add()
    {
        return view('admin.product_attribute_group.add');
    }

    protected function validateData($request)
    {

        $uniqueRuleCode = 'unique:product_attribute_groups';

        if (Route::currentRouteName() == 'product-attribute-group.update') {
            $uniqueRuleCode = 'unique:product_attribute_groups,name,' . $request->id;
        }
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255', $uniqueRuleCode],
        ]);
    }

    public function store(Request $request)
    {

        $this->validateData($request);
        $data = new ProductAttributeGroup($request->only('name', 'status'));
        $data->save();

        return redirect(route('product-attribute-group'))->with('success', 'Attribute Group Created Successfully');
    }

    public function edit($id)
    {

        return view('admin.product_attribute_group.edit', [
            'data' => ProductAttributeGroup::findOrFail($id),
        ]);
    }

    public function update(Request $request, $id)
    {

        $this->validateData($request);
        $data = ProductAttributeGroup::findOrFail($id);
        $data->fill($request->only('name', 'status'))->save();

        return redirect(route('product-attribute-group'))->with('success', 'Attribute Group Updated Successfully');
    }

    public function delete($id)
    {
        if (!$data = ProductAttributeGroup::whereId($id)->first()) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

        $data->delete();
        return redirect(route('product-attribute-group'))->with('success', 'Attribute Group  Deleted Successfully');
    }
}
