<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CustomerController extends Controller
{
    public function index(Request $request) {

        $keyword = $request->get('keyword', '');
        $records = Customer::select('id','firstname','lastname','email','telephone','status')
            ->when($keyword != '', function($q) use($keyword) {
                $q->where('firstname','like',"%$keyword%")->orWhere('lastname','like',"%$keyword%")->orWhere('email','like',"%$keyword%")->orWhere('telephone','like',"%$keyword%");
            })->orderBy('created_at','DESC')->paginate($this->defaultPaginate);
        return view('admin.customer.index',['records' => $records]);
    }

    public function add() {
        return view('admin.customer.add');
    }

    protected function validateData ($request) {
//        dd(Route::currentRouteName());

        $passwordValidations = [];
        if(Route::currentRouteName() == 'customer.store') {
            $passwordValidations = ['password' => ['required','min:6'],
            'confirmed' => ['required','same:password']
                ];
        }

        $customerValidations = [
            'firstname' => ['required', 'string', 'max:32'],
            'lastname' => ['required', 'string', 'max:32'],
            'email' => ['required','email'],
            'telephone' => ['required'],
            'status' => ['required'],
        ];

        $validationArray = array_merge($passwordValidations,$customerValidations);

        $this->validate($request,$validationArray);
    }

    public function store(Request $request) {

        $this->validateData($request);
        $data = new Customer($request->only('firstname','lastname','email','telephone','status'));
        $data->password = bcrypt($request->password);
        $data->save();

        return redirect(route('customer'))->with('success','Customer Created Successfully');
    }

    public function edit($id) {

        return view('admin.customer.edit',[
            'data' => Customer::findOrFail($id),
        ]);
    }

    public function update(Request $request,$id) {

        $this->validateData($request);
        $data = Customer::findOrFail($id);
        $data->fill($request->only('firstname','lastname','email','telephone','password','status'))->save();

        return redirect(route('customer'))->with('success','Customer Updated Successfully');
    }

    public function delete($id) {
        if(! $data = Customer::whereId($id)->first()) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

        $data->delete();
        return redirect(route('customer'))->with('success', 'Customer  Deleted Successfully');
    }

    public function getDetail(Request $request) {
        return Customer::select('firstname','lastname','email','telephone')->whereId($request->id)->first();
    }
}
