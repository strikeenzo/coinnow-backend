<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WeightClass;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class WeightClassController extends Controller
{
    public function index(Request $request) {
        $name = $request->get('name', '');

        $records = WeightClass::select('id','name','status','value','unit')
            ->when($name != '', function($q) use($name) {
                $q->where('name','like',"%$name%");
            })->orderBy('created_at','DESC')->paginate($this->defaultPaginate);
        return view('admin.weight_class.index',['records' => $records]);
    }

    public function add() {
        return view('admin.weight_class.add');
    }

    protected function validateData ($request) {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'unit' => ['required'],
            'value' => ['required'],
            'status' => ['required'],
        ]);
    }

    public function store(Request $request) {

        $this->validateData($request);
        $data = new WeightClass($request->only('name','unit','value','status'));
        $data->save();

        return redirect(route('weight-class'))->with('success','Weight Class Created Successfully');
    }

    public function edit($id) {

        return view('admin.weight_class.edit',[
            'data' => WeightClass::findOrFail($id),
        ]);
    }

    public function update(Request $request,$id) {

        $this->validateData($request);
        $data = WeightClass::findOrFail($id);
        $data->fill($request->only('name','unit','value','status'))->save();

        return redirect(route('weight-class'))->with('success','Weight Class Updated Successfully');
    }

    public function delete($id) {
        if(!$data = WeightClass::whereId($id)->first())
            return redirect()->back()->with('error', 'Something went wrong');

        $data->delete();
        return redirect(route('weight-class'))->with('success', 'Weight Class  Deleted Successfully');
    }
}
