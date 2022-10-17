<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AutoPriceChangeDetail;

class AutoPriceChangeDetailController extends Controller
{
    public function index($id)
    {
        $records = AutoPriceChangeDetail::where('auto_price_history_id', $id)->with('product')->paginate($this->defaultPaginate);
        return view('admin.history.auto_price_detail', ['records' => $records]);
    }
}
