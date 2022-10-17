<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AutoPriceChangeHistory;

class AutoPriceController extends Controller
{
    public function index()
    {
        $records = AutoPriceChangeHistory::orderBy('created_at', 'desc')->paginate($this->defaultPaginate);
        return view('admin.history.auto_price', ['records' => $records]);
    }
}
