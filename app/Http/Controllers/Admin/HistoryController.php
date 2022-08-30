<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $records = Notification::select('id', 'quantity', 'price', 'type', 'seen', 'created_at', 'product_id', 'seller_id')
        ->with(array('product' => function ($query) {
            $query->select('id', 'image')->with('productDescription:id,name,product_id');
        }))->with(['seller' => function($query) {
            $query->select('id', 'email');
        }])->whereIn('type', ['item_sell_auto', 'special_item_sell_auto'])
            ->orderBy('notification.created_at', 'DESC')->paginate($this->defaultPaginate);
        return view('admin.history.index', ['records' => $records]);
    }
}
