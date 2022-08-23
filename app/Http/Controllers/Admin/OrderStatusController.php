<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    public function index(Request $request) {
        $name = $request->get('name', '');

        $records = OrderStatus::select('id','name','status')
            ->when($name != '', function($q) use($name) {
                $q->where('name','like',"%$name%");
            })->paginate($this->defaultPaginate);
        return view('admin.order_status.index',['records' => $records]);
    }

    public function add() {
        return view('admin.order_status.add');
    }

    protected function validateData ($request) {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255']
        ]);
    }

    public function store(Request $request) {

        $this->validateData($request);
        $data = new OrderStatus($request->only('name','status'));
        $data->save();

        return redirect(route('order-status'))->with('success','Order Status Created Successfully');
    }

    public function edit($id) {

        return view('admin.order_status.edit',[
            'data' => OrderStatus::findOrFail($id),
        ]);
    }

    public function update(Request $request,$id) {

        $this->validateData($request);
        $data = OrderStatus::findOrFail($id);
        $data->fill($request->only('name','status'))->save();

        return redirect(route('order-status'))->with('success','Order Status Updated Successfully');
    }

    public function delete($id) {
        if(! $data = OrderStatus::whereId($id)->first()) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

        $data->delete();
        return redirect(route('order-status'))->with('success', 'Order Status  Deleted Successfully');
    }

}
