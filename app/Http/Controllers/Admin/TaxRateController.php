<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TaxRate;
use Illuminate\Http\Request;

class TaxRateController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->get('name', '');

        $records = TaxRate::select('id', 'name', 'rate', 'type', 'status')
            ->when($name != '', function ($q) use ($name) {
                $q->where('name', 'like', "%$name%");
            })->orderBy('created_at', 'DESC')->paginate($this->defaultPaginate);

        return view('admin.tax_rate.index', ['records' => $records]);
    }

    public function add()
    {
        return view('admin.tax_rate.add');
    }

    protected function validateData($request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'rate' => ['required'],
            'type' => ['required'],
        ]);
    }

    public function store(Request $request)
    {

        $this->validateData($request);
        $data = new TaxRate($request->only('name', 'rate', 'type', 'status'));
        $data->save();

        return redirect(route('tax-rate'))->with('success', 'Tax Rate Created Successfully');
    }

    public function edit($id)
    {

        return view('admin.tax_rate.edit', [
            'data' => TaxRate::findOrFail($id),
        ]);
    }

    public function update(Request $request, $id)
    {

        $this->validateData($request);
        $data = TaxRate::findOrFail($id);
        $data->fill($request->only('name', 'rate', 'type', 'status'))->save();

        return redirect(route('tax-rate'))->with('success', 'Tax Rate Updated Successfully');
    }

    public function delete($id)
    {
        if (!$data = TaxRate::whereId($id)->first()) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

        $data->delete();
        return redirect(route('tax-rate'))->with('success', 'Tax Rate  Deleted Successfully');
    }
}
