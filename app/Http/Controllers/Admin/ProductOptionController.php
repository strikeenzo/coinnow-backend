<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;
use App\Traits\CustomFileTrait;
use Illuminate\Http\Request;

class ProductOptionController extends Controller
{
    use CustomFileTrait;
    protected $path = '';

    public function __construct()
    {
        $this->path = public_path(config('constant.file_path.product_option'));
    }

    public function index(Request $request)
    {
        $name = $request->get('name', '');

        $records = ProductOption::select('id', 'name', 'type', 'status')
            ->when($name != '', function ($q) use ($name) {
                $q->where('name', 'like', "%$name%");
            })->orderBy('created_at', 'DESC')->paginate($this->defaultPaginate);

        return view('admin.product_option.index', ['records' => $records]);
    }

    public function add()
    {
        return view('admin.product_option.add');
    }

    protected function validateData($request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:50'],
            'type' => ['required', 'string', 'max:20'],
        ]);
    }

    public function store(Request $request)
    {

        $this->validateData($request);
        $data = new ProductOption($request->only('name', 'type', 'status'));
        $data->save();

        if (ProductOption::CheckType($request->type)) {
        }

        return redirect(route('product-option'))->with('success', 'Option Created Successfully');
    }

    protected function getOptionArray($id)
    {
        $dataArray = [];
        $optionValue = request()->option_value;
        foreach ($optionValue['name'] as $key => $value) {
            $image = null;
            $image = $this->saveCustomFileAndGetImageName($optionValue['image'][$key], $this->path);

            $dataArray[] = [
                'name' => $optionValue['name'][$key],
                'product_option_id' => $id,
                'sort_order' => $optionValue['sort_order'][$key],
                'image' => $image,
            ];
        }
        return $dataArray;
    }

    public function edit($id)
    {
        $data = ProductOption::findOrFail($id);

        $optionValueArray = [];

        return view('admin.product_option.edit', [
            'data' => $data,
            'optionValueArray' => $optionValueArray,
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validateData($request);
        $data = ProductOption::findOrFail($id);
        $data->fill($request->only('name', 'type', 'status'))->save();

        return redirect(route('product-option'))->with('success', 'Option Updated Successfully');
    }

    protected function deleteOptionValue($id)
    {
        $optionValue = ProductOptionValue::getOptionValueById($id);
        $oldValueImages = $optionValue->pluck('image', 'id')->toArray();
        foreach ($oldValueImages as $key => $value) {
            $this->removeOldImage($value, $this->path);
        }
        ProductOptionValue::where('product_option_id', $id)->delete();
    }

    public function delete($id)
    {
        if (!$data = ProductOption::whereId($id)->first()) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

        $data->delete();
        return redirect(route('product-option'))->with('success', 'Option  Deleted Successfully');
    }
}
