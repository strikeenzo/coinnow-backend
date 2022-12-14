<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductSellerRelation;
use App\Models\Trade;
use App\Traits\CustomFileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TradeController extends Controller
{
    use CustomFileTrait;
    protected $path = '';

    public function __construct()
    {
        $this->path = public_path(config('constant.file_path.trade'));
    }

    public function index(Request $request)
    {
        $trade = Trade::select('quantity', 'min_reward', 'max_reward', 'quantity_trade', 'image', 'product_id', 'product_image')->get();
        return view('admin.trade.index', ['trade' => $trade, 'path' => config('constant.file_path.trade')]);
    }

    public function add(Request $request)
    {
        $user = Auth::user();
        $seller = $user->seller->first();

        // $records = Product::select('id','image','category_id', 'model','price', 'min_price', 'max_price', 'location', 'quantity','sort_order','status', 'origin_id');
        //$records = $user->hasRole('Admin') || empty($seller) ? $records->where('seller_id', 0)->orWhereNull('seller_id') : $records->where('seller_id', 1);
        // $records = $records->WhereNot('seller_id', null);

        $records = ProductSellerRelation::select('product_id')->with(['product' => function ($query) {
            $query->with('productDescription:name,id,product_id');
        }])->groupby('product_id')->get();

        // return $records;

        // $records = $records->with('productDescription:name,id,product_id')->get();
        return view('admin.trade.add', ['records' => $records]);
    }

    public function store(Request $request)
    {
        $this->validateData($request);
        $quantity = $request->get('quantity_trade');

        //Product::find($request->get('product_id'))->decrement('quantity', $quantity);

        $trade = new Trade($request->only('quantity', 'min_reward', 'max_reward', 'quantity_trade', 'image', 'product_id', 'product_image', 'coin_quantity', 'origin_id'));

        //if has main image
        if ($request->hasFile('image')) {
            $this->createDirectory($this->path);
            $trade->image = $this->saveCustomFileAndGetImageName(request()->file('image'), $this->path);
        }
        $trade->save();
        return redirect(route('trade'))->with('success', 'Trade Created Successfully');
    }

    protected function validateData($request)
    {

        $conditionArray = [];

        $validateFields = [
            // 'name' => ['required'],
            // 'category_id' => ['required'],
            // 'model' => ['required'],
            // 'quantity' => ['required'],
            // 'price' => ['required'],
            // 'min_price' => ['required'],
            // 'max_price' => ['required'],
        ];

        $validationArray = array_merge($conditionArray, $validateFields);
        $this->validate($request, $validationArray);
    }
}
