<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EveryDayFee;

class EveryDayFeeController extends Controller
{
    public function index()
    {
        $records = EveryDayFee::paginate($this->defaultPaginate);
        return view('admin.fee.index', ['records' => $records]);
    }
}
