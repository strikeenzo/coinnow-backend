<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DOD;
use App\Models\ProductDescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class DealsOfTheDayController extends Controller
{
    public function index(Request $request) {
        $name = $request->get('name', '');
        $records = DOD::select('id','product_id')
            ->with('productDetails:id,image,price')
            ->with('productDescription:product_id,name')
            ->with('productSpecial:product_id,price')
            ->get();
        $data['pluckProducts'] =  ProductDescription::getActiveSpecialPluck();
        $data['pluckDODProducts'] = DOD::getPluck();

        return view('admin.dealoftheday.index',['records' => $records,'data' => $data]);
    }

    protected function validateData ($request) {
        $this->validate($request, [
            'product_id' => ['required']
        ]);
    }

    public function store(Request $request) {

        $this->validateData($request);
        DOD::truncate();
        $dodProducts = $this->getDODProduct($request->product_id);
        $data = DOD::insert($dodProducts);
        return redirect(route('trending_dod'))->with('success','Deals Of The Day Added!');
    }

    protected function getDODProduct($productId) {
        $dataArray = [];
        if(isset($productId)) {
            foreach($productId as $key => $value) {
                $dataArray[] = [
                    'product_id' => $value,
                ];
            }
        }
        return $dataArray;
    }


}
