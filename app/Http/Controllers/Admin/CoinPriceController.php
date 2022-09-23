<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CoinPrice;
use App\Models\PaymentHistory;

class CoinPriceController extends Controller
{
    public function index() {
        $records = CoinPrice::get();
        return view('admin.coinprice.index', ['records' => $records]);
    }

    public function edit($id) {
        $price = CoinPrice::where('id', $id)->first();
        return view('admin.coinprice.edit', ['price' => $price]);
    }

    public function update(Request $request, $id) {
        $this->validateData($request);
        $price = CoinPrice::where('id', $id)->first();
        $price->update(
            $request->all()
        );
        return redirect(route('coinPrice'))->with('success', 'Coin Price Updated Successfully');
    }

    public function paymentHistory() {
        $records = PaymentHistory::paginate($this->defaultPaginate);
        return view('admin.coinprice.history', ['records' => $records]);
    }

    private function validateData ($request) {
        $guideValidations = [
            'title' => ['required'],
            'coin' => ['required'],
            'price' => ['required'],
        ];

        $this->validate($request, $guideValidations);
    }
}
