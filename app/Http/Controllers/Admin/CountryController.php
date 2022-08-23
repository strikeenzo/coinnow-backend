<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index(Request $request) {
        $name = $request->get('name', '');

        $records = Country::select('id','name','status')
            ->when($name != '', function($q) use($name) {
                $q->where('name','like',"%$name%");
            })->orderBy('created_at','DESC')->paginate($this->defaultPaginate);
        return view('admin.country.index',['records' => $records]);
    }

    public function add() {
        return view('admin.country.add');
    }

    protected function validateData ($request) {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'iso_code_2' => ['required','max:2'],
            'iso_code_3' => ['required','max:3'],
            'address_format' => ['required'],
            'postcode_required' => ['required']
        ]);
    }

    public function store(Request $request) {

        $this->validateData($request);
        $data = new Country($request->only('name','iso_code_2','iso_code_3','address_format','postcode_required','status'));
        $data->save();

        return redirect(route('country'))->with('success','Country Created Successfully');
    }

    public function edit($id) {

        return view('admin.country.edit',[
            'data' => Country::findOrFail($id),
        ]);
    }

    public function update(Request $request,$id) {

        $this->validateData($request);
        $data = Country::findOrFail($id);
        $data->fill($request->only('name','iso_code_2','iso_code_3','address_format','postcode_required','status'))->save();

        return redirect(route('country'))->with('success','Country Updated Successfully');
    }

    public function delete($id) {
        if(! $data = Country::whereId($id)->first()) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

        $data->delete();
        return redirect(route('country'))->with('success', 'Country  Deleted Successfully');
    }
}
