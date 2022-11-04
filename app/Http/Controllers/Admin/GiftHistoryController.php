<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GiftHistory;

class GiftHistoryController extends Controller
{
    public function index()
    {
        $records = GiftHistory::with(['seller', 'product.productDescription'])->paginate($this->defaultPaginate);
        return view('admin.gift.index', ['records' => $records]);
    }
}
