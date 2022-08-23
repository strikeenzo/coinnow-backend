<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request) {
        $name = $request->get('name', '');

        $records = Review::with('customer:firstname,lastname,id')
             ->select('id','rating','customer_id')
             ->has('customer')
            ->paginate($this->defaultPaginate);

        return view('admin.review.index',['records' => $records]);
    }

    public function view($id) {

        return view('admin.review.view',[
            'data' => Review::with('customer')->findOrFail($id),
        ]);
    }

    public function delete($id) {
        if(! $data = Review::whereId($id)->first()) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

        $data->delete();
        return redirect(route('stock-status'))->with('success', 'Stock Status  Deleted Successfully');
    }
}
