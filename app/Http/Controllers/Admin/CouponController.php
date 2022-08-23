<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CouponController extends Controller
{
    public function index(Request $request) {
        $name = $request->get('name', '');

        $records = Coupon::select('id','code','discount','name','type','status')
            ->when($name != '', function($q) use($name) {
                $q->where('name','like',"%$name%");
            })->orderBy('created_at','DESC')->paginate($this->defaultPaginate);

        return view('admin.coupon.index',['records' => $records]);
    }

    public function add() {
        return view('admin.coupon.add');
    }

    protected function validateData ($request) {
        $uniqueRUleCode = 'unique:coupon';

        if(Route::currentRouteName() == 'coupon.update') {
            $uniqueRUleCode = 'unique:coupon,code,'.$request->id;
        }
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required'],
            'discount' => ['required','numeric','between:0,10000'],
            'code' => ['required',$uniqueRUleCode]
        ]);
    }

    public function store(Request $request) {

        $this->validateData($request);
        $data = new Coupon($request->only(Coupon::$fillableValue));
        $data->save();

        return redirect(route('coupon'))->with('success','Coupon Created Successfully');
    }

    public function edit($id) {

        return view('admin.coupon.edit',[
            'data' => Coupon::findOrFail($id),
        ]);
    }

    public function update(Request $request,$id) {

        $this->validateData($request);
        $data = Coupon::findOrFail($id);
        $data->fill($request->only(Coupon::$fillableValue))->save();

        return redirect(route('coupon'))->with('success','Coupon Updated Successfully');
    }

    public function delete($id) {
        if(! $data = Coupon::whereId($id)->first()) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

        $data->delete();
        return redirect(route('coupon'))->with('success', 'Coupon  Deleted Successfully');
    }
}
