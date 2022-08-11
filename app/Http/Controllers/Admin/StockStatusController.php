<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StockStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class StockStatusController extends Controller
{
    public function index(Request $request) {
        $name = $request->get('name', '');

        $records = StockStatus::select('id','name','status')
            ->when($name != '', function($q) use($name) {
                $q->where('name','like',"%$name%");
            })->orderBy('created_at','DESC')->paginate($this->defaultPaginate);
        return view('admin.stock_status.index',['records' => $records]);
    }

    public function add() {
        return view('admin.stock_status.add');
    }

    protected function validateData ($request) {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255']
        ]);
    }

    public function store(Request $request) {

        $this->validateData($request);
        $data = new StockStatus($request->only('name','status'));
        $data->save();

        return redirect(route('stock-status'))->with('success','Stock Status Created Successfully');
    }

    public function edit($id) {

        return view('admin.stock_status.edit',[
            'data' => StockStatus::findOrFail($id),
        ]);
    }

    public function update(Request $request,$id) {

        $this->validateData($request);
        $data = StockStatus::findOrFail($id);
        $data->fill($request->only('name','status'))->save();

        return redirect(route('stock-status'))->with('success','Stock Status Updated Successfully');
    }

    public function delete($id) {
        if(! $data = StockStatus::whereId($id)->first()) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

        $data->delete();
        return redirect(route('stock-status'))->with('success', 'Stock Status  Deleted Successfully');
    }
}
