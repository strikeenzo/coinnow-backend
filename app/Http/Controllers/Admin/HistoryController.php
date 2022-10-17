<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;

class HistoryController extends Controller
{
    public function index()
    {
        $records = Notification::select('id', 'quantity', 'price', 'type', 'seen', 'created_at', 'product_id', 'seller_id')
            ->with(array('product' => function ($query) {
                $query->select('id', 'image')->with('productDescription:id,name,product_id');
            }))->with(['seller' => function ($query) {
            $query->select('id', 'email');
        }])->whereIn('type', ['item_sell_auto', 'special_item_sell_auto'])
            ->orderBy('notification.created_at', 'DESC')->paginate($this->defaultPaginate);
        return view('admin.history.index', ['records' => $records]);
    }

    public function transaction($id)
    {
        if ($id) {
            $records = Notification::select('id', 'quantity', 'amount', 'type', 'seen', 'created_at', 'product_id', 'seller_id', 'receiver_id', 'sender_id')
                ->where('seller_id', $id)
                ->with(array('product' => function ($query) {
                    $query->select('id', 'image')->with('productDescription:id,name,product_id');
                }))->with(['seller' => function ($query) {
                $query->select('id', 'email');
            }])->with(['receiver' => function ($query) {
                $query->select('id', 'email');
            }])->whereIn('type', ['send_coin', 'receive_coin'])
                ->orderBy('notification.created_at', 'DESC')->paginate($this->defaultPaginate);
            return view('admin.history.transaction', ['records' => $records]);
        } else {
            $records = Notification::select('id', 'quantity', 'amount', 'type', 'seen', 'created_at', 'product_id', 'seller_id', 'receiver_id', 'sender_id')
                ->with(array('product' => function ($query) {
                    $query->select('id', 'image')->with('productDescription:id,name,product_id');
                }))->with(['seller' => function ($query) {
                $query->select('id', 'email');
            }])->with(['receiver' => function ($query) {
                $query->select('id', 'email');
            }])->whereIn('type', ['send_coin', 'receive_coin'])
                ->orderBy('notification.created_at', 'DESC')->paginate($this->defaultPaginate);
            return view('admin.history.transaction', ['records' => $records]);
        }
    }
}
