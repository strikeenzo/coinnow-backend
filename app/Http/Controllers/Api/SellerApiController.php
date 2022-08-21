<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Product;
use App\Models\Special;
use App\Models\Trade;
use Illuminate\Http\Request;
use App\Traits\CustomFileTrait;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Support\Facades\Date;
use Validator;
use File;
use DB;
use Auth;
use Hash;
use Carbon\Carbon;

class SellerApiController extends Controller
{
    private $getUser;
    use CustomFileTrait;
    protected $path = '';

    public function __construct()
    {
        $this->path = public_path(config('constant.file_path.user'));
        $this->middleware(function ($request, $next) {
            $this->getUser = Auth::guard('seller')->user();
            return $next($request);
        });
    }


    public function getSellerDetails()
    {
        $specials = Special::select('quantity', 'product_id')->where('seller_id', $this->getUser->id)->where('quantity', '>', 0)->with('product:id,image,points', 'productDescription:id,name,product_id')->get();
        //$specials = Special::join('product', 'product.id', '=', 'special.product_id')->get();
        return  ['status' => 1, 'data' => $this->getUser, 'specials' => $specials];
    }

    public function getSellers(Request $request)
    {
        try {
            $phone_number = $request->get('q', '');
            $records = Seller::where('telephone', 'like', empty($phone_number) ? "" : "%$phone_number%")
                ->where('id', '!=', $this->getUser->id)
                ->paginate($this->defaultPaginate);

            return ['status' => 1, 'data' => $records];
        } catch (\Exception $e) {
            return ['status' => 0, 'message' => 'Error'];
        }
    }

    public function sendCoins(Request $request)
    {
        $amount = $request->amount;
        $receiverID = $request->receiver;
        $receiver = Seller::find($receiverID);

        if ($receiverID == $this->getUser->id) {
            return ['status' => 0, 'message' => 'Unable to send coins to yourself.'];
        }
        if ($amount < 1) {
            return ['status' => 0, 'message' => 'Amount must be greater than zero.'];
        }

        if (empty($receiver)) {
            return ['status' => 0, 'message' => 'Receiver not found'];
        }

        if ($this->getUser->balance < $amount) {
            return ['status' => 0, 'message' => 'No enough balance'];
        }
        $seller_balance = $this->getUser->balance;
        $receiver_balance = $receiver->balance;
        $this->getUser->update(['balance' => $seller_balance - $amount]);
        $receiver->balance = $receiver_balance + $amount;
        $receiver->save();
        $notification_data = array(
            'type' => 'send_coin',
            'seller_id' => $this->getUser->id,
            'receiver_id' => $receiverID,
            'amount' => $amount,
            'balance' => $seller_balance,
            'seen' => 0,
        );
        $new_notification = new Notification($notification_data);
        $new_notification->save();

        $notification_data = array(
            'type' => 'receive_coin',
            'seller_id' => $receiverID,
            'sender_id' => $this->getUser->id,
            'amount' => $amount,
            'balance' => $receiver_balance,
            'seen' => 0,
        );
        $new_notification = new Notification($notification_data);
        $new_notification->save();
        return ['status' => 1, 'message' => 'Transfer Success!', 'origin_balance' => $seller_balance, 'balance' => $this->getUser->balance];
    }

    public function getHistory()
    {
        try {

            $history = Notification::select('id', 'quantity', 'type', 'seen', 'created_at', 'product_id', 'seller_id', 'receiver_id', 'amount', 'balance', 'sender_id')
                ->with('receiver:id,telephone,firstname,lastname,email')
                ->with('sender:id,telephone,firstname,lastname,email')
                ->with(array('product' => function ($query) {
                    $query->select('id', 'image')->with('productDescription:id,name,product_id');
                }))
                ->where('seller_id', $this->getUser->id)
                ->orderBy('notification.created_at', 'DESC')->paginate($this->defaultPaginate);
            return ['status' => 1, 'data' => $history];
        } catch (\Exception $e) {
            return ['status' => 0, 'message' => $e];
        }
    }

    public function getExpenses()
    {
        try {
            $history = Notification::select('id', 'quantity', 'price', 'type', 'seen', 'created_at', 'product_id')->with(array('product' => function ($query) {
                $query->select('id', 'image', 'price')->with('productDescription:id,name,product_id');
            }))->where('seller_id', $this->getUser->id)
                ->whereIn('type', ['item_buy', 'special_item_buy'])
                ->orderBy('notification.created_at', 'DESC')->paginate($this->defaultPaginate);
            return ['status' => 1, 'data' => $history];
        } catch (\Exception $e) {
            return ['status' => 0, 'message' => $e];
        }
    }

    public function getEarnings(Request $request)
    {
        try {

            $history = Notification::select('id', 'quantity', 'price', 'type', 'seen', 'created_at', 'product_id')->with(array('product' => function ($query) {
                $query->select('id', 'image', 'price')->with('productDescription:id,name,product_id');
            }))->where('seller_id', $this->getUser->id)
                ->whereIn('type', ['item_sell', 'special_item_sell'])
                ->orderBy('notification.created_at', 'DESC')->paginate($this->defaultPaginate);
            return ['status' => 1, 'data' => $history];
        } catch (\Exception $e) {
            return ['status' => 0, 'message' => $e];
        }
    }

    public function balanceHistory(Request $request)
    {
        try {
            $history = Notification::select('id', 'quantity', 'type', 'seen', 'created_at', 'product_id', 'seller_id', 'sender_id', 'receiver_id', 'amount', 'price', 'balance')
                ->with('receiver:id,telephone,firstname,lastname,email')
                ->with('sender:id,telephone,firstname,lastname,email')
                ->with(array('product' => function ($query) {
                    $query->select('id', 'image')->with('productDescription:id,name,product_id');
                }))
                ->where('seller_id', $this->getUser->id)
                ->whereIn('type', ['send_coin', 'receive_coin', 'item_sell', 'special_item_sell', 'item_buy', 'special_item_buy', 'trade'])
                ->orderBy('notification.created_at', 'DESC')->paginate($this->defaultPaginate);
            return ['status' => 1, 'data' => $history];
        } catch (\Exception $e) {
            return ['status' => 0, 'message' => $e];
        }
    }

    //search products
    public function searchProducts(Request $request)
    {
        try {
            $keyword = $request->get('q', '');
            // error_log($this->getUser->id);
            $records = Product::select('id', 'image', 'price', 'quantity', 'sort_order', 'status', 'sale', 'created_at', 'deleted_at')
                ->where('quantity', '>', 0)
                ->where('seller_id', $this->getUser->id)
                ->with('productDescription:name,id,product_id', 'special:product_id,price,start_date,end_date')
                ->when(!empty($keyword), function ($q) use ($keyword) {
                    $q->whereHas('productDescription', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%$keyword%");
                    });
                })
                //->orderBy('sort_order','ASC')
                ->get();

            return ['status' => 1, 'data' => $records];
        } catch (\Exception $e) {
            return ['status' => 0, 'message' => 'Error'];
        }
    }

    public function getTrades(Request $request)
    {
        // $product_id = Product::where('seller_id', $this->getUser->id)->first();
        $trade = Trade::select('id', 'quantity', 'min_reward', 'origin_id','max_reward', 'quantity_trade', 'image', 'product_id', 'product_image', 'coin_quantity')->where('quantity', '>', 0)->get();
        return ['status' => 1, 'data' => $trade];
    }

    public function trade(Request $request) {

        // error_log($request->get('product_id'));
        $product = Product::where('seller_id', $this->getUser->id)->where('origin_id', $request->get('product_id'))->get();
        // return $product;
        if (count($product) == 0) {
            return ['status' => 3];
        }
        if ($product[0]['quantity'] < $request->get('quantity_trade'))
        {
            return ['status' => 2];
        }

        //error_log($request->get('coin_quantity'));
        try {
            $product = Product::where('seller_id', $this->getUser->id)->where('origin_id', $request->get('product_id'))->decrement('quantity', $request->get('quantity_trade'));
            //error_log(count($product));
            Seller::find($this->getUser->id)->increment('balance', $request->get('coin_quantity'));
            Trade::find($request->get('id'))->decrement('quantity', 1);

            $amount = Seller::where('id', $this->getUser->id)->select('balance')->get();
            $amount = $amount[0]['balance'];
            $notification = new Notification(['product_id' => $request->get('product_id'), 'quantity' => $request->get('quantity_trade'), 'type' => 'trade', 'amount' => $request->get('coin_quantity'), 'seller_id' => $this->getUser->id, 'balance' => $amount]);
            $notification->save();

            $trade_count = Trade::find($request->get('id'))->select('quantity')->get();
            $trade_count = $trade_count[0]['quantity'];
            // return ['status' => $trade_count];
            if ($trade_count <= 0) {
                return ['status' => 4];
            }
            return ['status' => 1];
        } catch(\Exception $e) {
            error_log($e->getMessage());
            return ['status' => 0, 'error' => $e->getMessage()];
        }

    }

    public function updateProfile(Request $request)
    {

        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'firstname'          => 'required|regex:/^[\pL\s\-]+$/u',
                    'telephone'     => 'required|max:11',
                ]
            );

            if ($validator->fails()) {
                $message = $this->one_validation_message($validator);
                return  ['status' => 0, 'message' => $message];
            }

            $update = Seller::where('id', $this->getUser->id)->update($request->all());
            $getNew = Seller::select('firstname', 'lastname', 'email', 'store_name', 'telephone')->findOrFail($this->getUser->id);
            return  ['status' => 1, 'message' => 'Profile updated successfully!', 'data' => $getNew];
        } catch (\Exception $e) {
            return  ['status' => 0, 'message' => 'Error'];
        }
    }

    public function updateProduct(Request $request, $id)
    {


        return  ['status' => 1, 'message' => 'You can not change the price'];

        //       $product = Product::whereId($id)->first();
        //       if (!empty($product)) {
        //           $product->price = $request->price;
        //           $product->save();
        //       }
        //       return  ['status'=> 1,'message'=>'Product updated successfully!' ];
    }

    public function listProductSale(Request $request, $id)
    {
        $product = Product::whereId($id)->first();
        if (!empty($product)) {
            $seconds = rand(10800, 21600);
            $sell_date = Carbon::now()->addSeconds($seconds);
            $product->sell_date = $sell_date;
            $product->sale = 1;
            $product->save();
        }
        return  ['status' => 1, 'message' => 'Product updated successfully!'];
    }

    public function changePassword(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'current_password'     => 'required',
                    'new_password'     => 'required',
                ]
            );
            if ($validator->fails()) {
                $message = $this->one_validation_message($validator);
                return  ['status' => 0, 'message' => $message];
            }

            $current_password = $this->getUser->password;
            if (Hash::check($request->current_password, $current_password)) {
                $seller = Seller::find($this->getUser->id);
                $seller->password = Hash::make($request->new_password);
                $seller->save();
                return  ['status' => 1, 'message' => 'Password successfully changed'];
            } else {
                return  ['status' => 0, 'message' => 'Current password wrong!'];
            }
        } catch (\Exception $e) {
            return  ['status' => 0, 'message' => 'Error'];
        }
    }

    public function one_validation_message($validator)
    {
        $validation_messages = $validator->getMessageBag()->toArray();
        $validation_messages1 = array_values($validation_messages);
        $new_validation_messages = [];
        for ($i = 0; $i < count($validation_messages1); $i++) {
            $inside_element = count($validation_messages1[$i]);
            for ($j = 0; $j < $inside_element; $j++) {
                array_push($new_validation_messages, $validation_messages1[$i]);
            }
        }
        return implode(' ', $new_validation_messages[0]);
    }
}
