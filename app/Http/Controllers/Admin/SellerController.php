<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class SellerController extends Controller
{
    public function index(Request $request) {

        $keyword = $request->get('keyword', '');
        $records = Seller::select('id','firstname','lastname','email','telephone', 'store_name', 'status')
            ->when($keyword != '', function($q) use($keyword) {
                $q->where('firstname','like',"%$keyword%")
                    ->orWhere('lastname','like',"%$keyword%")
                    ->orWhere('email','like',"%$keyword%")
                    ->orWhere('store_name','like',"%$keyword%")
                    ->orWhere('telephone','like',"%$keyword%");
            })->orderBy('created_at','DESC')->paginate($this->defaultPaginate);
        return view('admin.seller.index',['records' => $records]);
    }

    public function add() {
        return view('admin.seller.add');
    }

    protected function validateData ($request) {
//        dd(Route::currentRouteName());

        $passwordValidations = [];
        if(Route::currentRouteName() == 'seller.store') {
            $passwordValidations = ['password' => ['required','min:6'],
            'confirmed' => ['required','same:password']
                ];
        }

        $sellerValidations = [
            'firstname' => ['required', 'string', 'max:32'],
            'lastname' => ['required', 'string', 'max:32'],
            'store_name' => ['required', 'string', 'max:32'],
            'email' => ['required','email'],
            'telephone' => ['required'],
            'status' => ['required'],
        ];

        $validationArray = array_merge($passwordValidations,$sellerValidations);

        $this->validate($request,$validationArray);
    }

    public function store(Request $request) {

        $this->validateData($request);
        $data = new Seller($request->only('firstname','lastname','email', 'store_name', 'telephone','status'));
        $data->password = bcrypt($request->password);
        $data->save();

        return redirect(route('seller'))->with('success','Seller Created Successfully');
    }

    public function edit($id) {

        return view('admin.seller.edit',[
            'data' => Seller::findOrFail($id),
        ]);
    }

    public function update(Request $request,$id) {

        $this->validateData($request);
        $data = Seller::findOrFail($id);
        $data->fill($request->only('firstname','lastname','email','telephone', 'store_name', 'password','status'))->save();

        return redirect(route('seller'))->with('success','Seller Updated Successfully');
    }

    public function delete($id) {
        if(! $data = Seller::whereId($id)->first()) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

        $data->delete();
        return redirect(route('seller'))->with('success', 'Seller  Deleted Successfully');
    }

    public function getDetail(Request $request) {
        return Seller::select('firstname','lastname','email','telephone', 'store_name',)->whereId($request->id)->first();
    }
}
