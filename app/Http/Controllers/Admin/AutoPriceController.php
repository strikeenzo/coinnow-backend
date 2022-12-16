<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AutoPriceChangeDetail;
use App\Models\AutoPriceChangeHistory;

class AutoPriceController extends Controller
{
    public function index()
    {
        $records = AutoPriceChangeHistory::orderBy('created_at', 'desc')->paginate($this->defaultPaginate);
        $total_collected = AutoPriceChangeHistory::sum('collected');
        $total_distributed = AutoPriceChangeHistory::sum('distributed');
        $total_remaining = $total_collected - $total_distributed;
        for ($i = 0; $i < count($records); $i++) {
            $collected = $distributed = 0;
            $items = AutoPriceChangeDetail::where('auto_price_history_id', $records[$i]->id)->get();
            for ($j = 0; $j < count($items); $j++) {
                if ($items[$j]->profit < 0) {
                    $collected -= $items[$j]->profit;
                } else {
                    $distributed += $items[$j]->profit;
                }
            }
            $records[$i]['collected1'] = $collected;
            $records[$i]['distributed1'] = $distributed;
        }
        return view('admin.history.auto_price', ['records' => $records, 'total_remaining' => $total_remaining]);
    }
}
