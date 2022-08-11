<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shipping;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function index(Request $request) {
        $name = $request->get('name', '');

        $records = Shipping::select('id','name','shipping_charge','status')
            ->when($name != '', function($q) use($name) {
                $q->where('name','like',"%$name%");
            })->orderBy('created_at','DESC')->paginate($this->defaultPaginate);
        return view('admin.shipping.index',['records' => $records]);
    }

    public function add() {
        return view('admin.shipping.add');
    }

    protected function validateData ($request) {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'shipping_charge' => ['required'],
        ]);
    }

    public function store(Request $request) {

        $this->validateData($request);
        $data = new Shipping($request->only('name','shipping_charge','status'));
        $data->save();

        return redirect(route('shipping'))->with('success','Shipping Created Successfully');
    }

    public function edit($id) {

        return view('admin.shipping.edit',[
            'data' => Shipping::findOrFail($id),
        ]);
    }

    public function update(Request $request,$id) {

        $this->validateData($request);
        $data = Shipping::findOrFail($id);
        $data->fill($request->only('name','shipping_charge','status'))->save();

        return redirect(route('shipping'))->with('success','Shipping Updated Successfully');
    }

    public function delete($id) {
        if(! $data = Shipping::whereId($id)->first()) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

        $data->delete();
        return redirect(route('shipping'))->with('success', 'Shipping Deleted Successfully');
    }
}
