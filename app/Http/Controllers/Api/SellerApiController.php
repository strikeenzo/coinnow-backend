<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clan;
use App\Models\CoinPrice;
use App\Models\DigitalShowImage;
use App\Models\DigitalShowImageSellerRelation;
use App\Models\EnvironmentalVariable;
use App\Models\Notification;
use App\Models\PaymentHistory;
use App\Models\ProductSellerRelation;
use App\Models\Seller;
use App\Models\Special;
use App\Models\Trade;
use App\Models\User;
use App\Traits\CustomFileTrait;
use Auth;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Validator;

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
        $user = Seller::where('id', $this->getUser->id)->with(['clan' => function ($query) {
            $query->with(['product' => function ($query) {
                $query->with('productDescription');
            }, 'owner', 'members']);
        }])->first();
        //$specials = Special::join('product', 'product.id', '=', 'special.product_id')->get();
        return ['status' => 1, 'data' => $user, 'specials' => $specials];
    }

    public function getSellers(Request $request)
    {
        try {
            $email = $request->get('q', '');
            $records = Seller::where('email', 'like', empty($email) ? "" : "%$email%")
                ->where('id', '!=', $this->getUser->id)
                ->paginate($this->defaultPaginate);

            return ['status' => 1, 'data' => $records];
        } catch (\Exception$e) {
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
        $this->getUser->update(['balance' => $seller_balance - $amount]);
        $receiver->balance = $receiver_balance + $amount;
        $receiver->save();
        return ['status' => 1, 'message' => 'Transfer Success!', 'origin_balance' => $seller_balance, 'balance' => $this->getUser->balance];
    }

    public function getHistory()
    {
        try {

            $history = Notification::select('id', 'quantity', 'type', 'seen', 'created_at', 'product_id', 'seller_id', 'receiver_id', 'amount', 'balance', 'sender_id', 'price', 'clan_id')
                ->with('receiver:id,telephone,firstname,lastname,email')
                ->with('sender:id,telephone,firstname,lastname,email')
                ->with('product:seller_id')
                ->with(['clan' => function ($query) {
                    $query->with(['owner' => function ($query) {
                        $query->select('id', 'firstname', 'lastname');
                    }]);
                }])
                ->with(array('product' => function ($query) {
                    $query->select('id', 'image')->with('productDescription:id,name,product_id');
                }))
                ->where('seller_id', $this->getUser->id)
                ->orderBy('notification.created_at', 'DESC')->paginate($this->defaultPaginate);
            return ['status' => 1, 'data' => $history];
        } catch (\Exception$e) {
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
        } catch (\Exception$e) {
            return ['status' => 0, 'message' => $e];
        }
    }

    public function getEarnings(Request $request)
    {
        try {

            $history = Notification::select('id', 'quantity', 'price', 'type', 'seen', 'created_at', 'product_id')->with(array('product' => function ($query) {
                $query->select('id', 'image', 'price')->with('productDescription:id,name,product_id');
            }))->where('seller_id', $this->getUser->id)
                ->whereIn('type', ['item_sell', 'special_item_sell', 'item_sell_auto', 'special_item_sell_auto'])
                ->orderBy('notification.created_at', 'DESC')->paginate($this->defaultPaginate);
            return ['status' => 1, 'data' => $history];
        } catch (\Exception$e) {
            return ['status' => 0, 'message' => $e];
        }
    }

    public function balanceHistory(Request $request)
    {
        try {
            $history = Notification::select('id', 'quantity', 'type', 'seen', 'created_at', 'product_id', 'seller_id', 'sender_id', 'receiver_id', 'amount', 'price', 'balance', 'clan_id')
                ->with('receiver:id,telephone,firstname,lastname,email')
                ->with('sender:id,telephone,firstname,lastname,email')
                ->with(['clan' => function ($query) {
                    $query->with(['owner' => function ($query) {
                        $query->select('id', 'firstname', 'lastname');
                    }]);
                }])
                ->with(array('product' => function ($query) {
                    $query->select('id', 'image')->with('productDescription:id,name,product_id');
                }))
                ->where('seller_id', $this->getUser->id)
            // ->whereIn('type', ['send_coin', 'receive_coin', 'item_sell', 'special_item_sell', 'item_sell_auto', 'special_item_sell_auto', 'item_buy', 'special_item_buy', 'trade'])
                ->orderBy('notification.created_at', 'DESC')->orderBy('notification.id', 'DESC')->paginate($this->defaultPaginate);
            return ['status' => 1, 'data' => $history];
        } catch (\Exception$e) {
            return ['status' => 0, 'message' => $e];
        }
    }

    public function getClanHistoryById($id)
    {
        try {
            $history = Notification::where('clan_id', $id)->select('id', 'quantity', 'type', 'seen', 'created_at', 'product_id', 'seller_id', 'sender_id', 'receiver_id', 'amount', 'price', 'balance', 'clan_id')
                ->with('receiver:id,telephone,firstname,lastname,email')
                ->with('sender:id,telephone,firstname,lastname,email')
                ->with(['clan' => function ($query) {
                    $query->with(['owner' => function ($query) {
                        $query->select('id', 'firstname', 'lastname');
                    }]);
                }])
                ->with(array('product' => function ($query) {
                    $query->select('id', 'image')->with('productDescription:id,name,product_id');
                }))
                ->where('type', '!=', 'clan_join')
            // ->whereIn('type', ['send_coin', 'receive_coin', 'item_sell', 'special_item_sell', 'item_sell_auto', 'special_item_sell_auto', 'item_buy', 'special_item_buy', 'trade'])
                ->orderBy('notification.created_at', 'DESC')->orderBy('notification.id', 'DESC')->paginate($this->defaultPaginate);
            return ['status' => 1, 'data' => $history];
        } catch (\Exception$e) {
            return ['status' => 0, 'message' => $e];
        }
    }

    //search products
    public function searchProducts(Request $request)
    {
        try {
            $keyword = $request->get('q', '');
            // error_log($this->getUser->id);

            $records = $this->getUser->products()->wherePivot('quantity', '>', 0)
                ->select('product.id', 'product.image', 'product.sort_order', 'product.status', 'product.updated_at', 'product.created_at', 'product.price', 'product.deleted_at')
                ->with('productDescription:name,id,product_id', 'special:product_id,price,start_date,end_date')
                ->when(!empty($keyword), function ($q) use ($keyword) {
                    $q->whereHas('productDescription', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%$keyword%");
                    });
                })
                ->get();
            // $records = Product::select('id', 'image', 'price', 'quantity', 'sort_order', 'status', 'sale', 'created_at', 'deleted_at', 'updated_at')
            //     ->where('quantity', '>', 0)
            //     ->where('seller_id', $this->getUser->id)
            //     ->with('productDescription:name,id,product_id', 'special:product_id,price,start_date,end_date')
            //     ->when(!empty($keyword), function ($q) use ($keyword) {
            //         $q->whereHas('productDescription', function ($q) use ($keyword) {
            //             $q->where('name', 'like', "%$keyword%");
            //         });
            //     })
            //     //->orderBy('sort_order','ASC')
            //     ->get();

            return ['status' => 1, 'data' => $records];
        } catch (\Exception$e) {
            return ['status' => 0, 'message' => 'Error'];
        }
    }

    public function getTrades(Request $request)
    {
        // $product_id = Product::where('seller_id', $this->getUser->id)->first();
        $trade = Trade::select('id', 'quantity', 'min_reward', 'origin_id', 'max_reward', 'quantity_trade', 'image', 'product_id', 'product_image', 'coin_quantity')->where('quantity', '>', 0)->get();
        return ['status' => 1, 'data' => $trade];
    }

    public function trade(Request $request)
    {

        // error_log($request->get('product_id'));
        $product = ProductSellerRelation::where('seller_id', $this->getUser->id)->where('product_id', $request->get('product_id'))->where('quantity', '>', 0)->get();
        // return $product;
        if (count($product) == 0) {
            return ['status' => 3];
        }
        if ($product[0]['quantity'] < $request->get('quantity_trade')) {
            return ['status' => 2];
        }

        //error_log($request->get('coin_quantity'));
        try {
            $product = ProductSellerRelation::where('seller_id', $this->getUser->id)->where('product_id', $request->get('product_id'))->decrement('quantity', $request->get('quantity_trade'));
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
        } catch (\Exception$e) {
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
                    'firstname' => 'required|regex:/^[\pL\s\-]+$/u',
                    'telephone' => 'required|max:11',
                ]
            );

            if ($validator->fails()) {
                $message = $this->one_validation_message($validator);
                return ['status' => 0, 'message' => $message];
            }

            $update = Seller::where('id', $this->getUser->id)->update($request->all());
            $getNew = Seller::select('firstname', 'lastname', 'email', 'store_name', 'telephone')->findOrFail($this->getUser->id);
            return ['status' => 1, 'message' => 'Profile updated successfully!', 'data' => $getNew];
        } catch (\Exception$e) {
            return ['status' => 0, 'message' => 'Error'];
        }
    }

    public function updateProduct(Request $request, $id)
    {

        return ['status' => 1, 'message' => 'You can not change the price'];

        //       $product = Product::whereId($id)->first();
        //       if (!empty($product)) {
        //           $product->price = $request->price;
        //           $product->save();
        //       }
        //       return  ['status'=> 1,'message'=>'Product updated successfully!' ];
    }

    public function listProductSale(Request $request, $id)
    {
        $product = ProductSellerRelation::whereId($id)->first();
        $env = EnvironmentalVariable::first();
        if (!empty($product)) {
            $seconds = rand($env->min_time, $env->max_time);
            $sell_date = Carbon::now()->addSeconds($seconds);
            $product->sell_date = $sell_date;
            $product->sale = 1;
            $product->save();
            $notification = new Notification(['product_id' => $request->get('product_id'), 'quantity' => $request->get('quantity'), 'type' => 'item_sell_list', 'seller_id' => $this->getUser->id, 'price' => $request->get('price')]);
            $notification->save();
            return ['status' => 1, 'message' => $notification];
        }
        return ['status' => 0, 'message' => 'Product update failed!'];

    }

    public function changePassword(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'current_password' => 'required',
                    'new_password' => 'required',
                ]
            );
            if ($validator->fails()) {
                $message = $this->one_validation_message($validator);
                return ['status' => 0, 'message' => $message];
            }

            $current_password = $this->getUser->password;
            if (Hash::check($request->current_password, $current_password)) {
                $seller = Seller::find($this->getUser->id);
                $seller->password = Hash::make($request->new_password);
                $seller->save();
                return ['status' => 1, 'message' => 'Password successfully changed'];
            } else {
                return ['status' => 0, 'message' => 'Current password wrong!'];
            }
        } catch (\Exception$e) {
            return ['status' => 0, 'message' => 'Error'];
        }
    }

    public function uploadImage(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'image' => 'required|image',
                ]
            );
            if ($validator->fails()) {
                $message = $this->one_validation_message($validator);
                return ['status' => 0, 'message' => $message];
            }

            if ($request->hasFile('image')) {
                $digitalShowImage = new DigitalShowImage();
                $this->createDirectory($this->path);
                $digitalShowImage->image = $this->saveCustomFileAndGetImageName($request->file('image'), $this->path);
                $digitalShowImage->heart_count = 0;
                $digitalShowImage->comment_count = 0;
                $digitalShowImage->owner_id = $this->getUser->id;
                $digitalShowImage->comment = $request->comment;
                $digitalShowImage->save();
            }
            return ['status' => 1, 'message' => 'Image successfully uploaded'];
        } catch (\Exception$e) {
            return ['status' => 0, 'message' => $e];
        }
    }

    public function getMyImages(Request $request)
    {
        try {
            $images = DigitalShowImage::where('owner_id', $this->getUser->id)->paginate($this->defaultPaginate);
            return ['status' => 1, 'images' => $images];
        } catch (\Exception$e) {
            return ['status' => 0, 'message' => $e];
        }
    }

    public function getImages(Request $request)
    {
        try {
            $images = DigitalShowImage::orderBy('created_at', 'DESC')->with(['owner' => function ($query) {
                $query->select('id', 'firstname', 'lastname');
            }])->paginate(1);
            $relation = DigitalShowImageSellerRelation::where('user_id', $this->getUser->id)->where('image_id', $images[0]->id)->first();
            if ($relation) {
                if (!$relation->view_status) {
                    $relation->view_status = true;
                    $relation->save();
                }
            } else {
                $relation = DigitalShowImageSellerRelation::create([
                    'user_id' => $this->getUser->id,
                    'image_id' => $images[0]->id,
                    'view_status' => true,
                ]);
            }
            return ['status' => 1, 'images' => $images, 'relation' => $relation];
        } catch (\Exception$e) {
            return ['status' => 0, 'message' => $e];
        }
    }

    public function toogleVoteImage(Request $request)
    {
        try {
            $relation = DigitalShowImageSellerRelation::where('user_id', $this->getUser->id)->where('image_id', $request->id)->first();
            if ($relation) {
                $relation->heart = !$relation->heart;
                $relation->save();
            }
            return ['status' => 1, 'relation' => $relation];
        } catch (\Exception$e) {
            return ['status' => 0, 'message' => $e];
        }
    }

    public function payByStripe(Request $request)
    {
        $stripe_key = env('STRIPE_SECURITY_KEY');
        \Stripe\Stripe::setApiKey($stripe_key);
        $price = CoinPrice::where('id', $request->id)->first();
        $intent = \Stripe\PaymentIntent::create([
            'amount' => $price->price * 100,
            'currency' => 'usd',
        ]);
        $client_secret = $intent->client_secret;
        return ['status' => 1, 'clientSecret' => $client_secret];
    }

    public function buyCoin(Request $request)
    {
        $seller = Seller::where('id', $this->getUser->id)->first();
        $price = CoinPrice::where('id', $request->id)->first();
        $seller_balance = $seller->balance;
        $seller->balance += $price->coin;
        $seller->save();
        $notification_data = array(
            'type' => 'buy_coin',
            'seller_id' => $this->getUser->id,
            'amount' => $price->coin,
            'balance' => $seller_balance,
            'seen' => 0,
        );
        $new_notification = new Notification($notification_data);
        $new_notification->save();
        PaymentHistory::create([
            'user_id' => $this->getUser->id,
            'coin' => $price->coin,
            'price' => $price->price,
        ]);
        return [
            'status' => 1, 'message' => 'Paid Successfully',
        ];
    }

    public function getMyClans()
    {
        $total_price = Clan::where('owner_id', $this->getUser->id)->first()->history->where('type', 'clan_joining')->sum('price');
        $total_count = Clan::where('owner_id', $this->getUser->id)->count();
        $clans = Clan::where('owner_id', $this->getUser->id)->with(['product' => function ($query) {
            $query->with('productDescription');
        }, 'members'])->withSum(['history' => function ($query) {
            $query->where('type', 'clan_joining');
        }], 'price')->get();
        return [
            'status' => 1, 'clans' => $clans, "total" => [
                'price' => $total_price,
                'count' => $total_count,
            ],
        ];
    }

    public function getClans()
    {
        $clans = Clan::where('owner_id', null)->with(['product' => function ($query) {
            $query->with('productDescription');
        }])->get();
        return [
            'status' => 1, 'clans' => $clans,
        ];
    }

    public function getJoinClans()
    {
        $clans = Clan::whereNotNull('owner_id')->with(['product' => function ($query) {
            $query->with('productDescription');
        }, 'owner' => function ($query) {
            $query->select(['id', 'firstname', 'lastname']);
        }, 'members'])->paginate($this->defaultPaginate);
        return $clans;
    }

    public function joinClan($id)
    {
        $clan = Clan::where('id', $id)->first();
        $seller = Seller::where('id', $this->getUser->id)->first();
        $balance = $seller->balance;
        if ($clan->fee > $seller->balance) {
            return [
                'status' => 0,
                'messge' => 'No enough balance',
            ];
        }
        $seller->clan_id = $clan->id;
        $seller->balance -= $clan->fee;
        $seller->save();
        $owner = $clan->owner;
        $owner_balance = $owner->balance;
        $owner->balance += $clan->fee;
        $owner->save();
        $notification_data = array(
            'type' => 'clan_join',
            'clan_id' => $clan->id,
            'seller_id' => $this->getUser->id,
            'quantity' => 1,
            'price' => $clan->fee,
            'balance' => $balance,
            'seen' => 0,
        );
        $new_notification = new Notification($notification_data);
        $new_notification->save();
        $notification_data = array(
            'type' => 'clan_joining',
            'clan_id' => $clan->id,
            'seller_id' => $owner->id,
            'quantity' => 1,
            'price' => $clan->fee,
            'balance' => $owner_balance,
            'sender_id' => $this->getUser->id,
            'seen' => 0,
        );
        $new_notification = new Notification($notification_data);
        $new_notification->save();
        return [
            'status' => 1,
            'message' => 'Join Successful',
        ];
    }

    public function leaveClan()
    {
        $seller = Seller::where('id', $this->getUser->id)->first();
        $seller->clan_id = null;
        $seller->save();
        return [
            'status' => 1,
            'message' => 'Leave Successful',
        ];
    }

    public function buyClan(Request $request)
    {
        $seller = Seller::where('id', $this->getUser->id)->first();
        $clan = Clan::where('id', $request->id)->first();
        $balance = $seller->balance;
        if ($clan->price > $seller->balance) {
            return [
                'status' => 0,
                'messge' => 'No enough balance',
            ];
        }
        $clan->owner_id = $seller->id;
        $seller->balance -= $clan->price;
        $seller->save();
        $clan->save();
        $notification_data = array(
            'type' => 'clan_buy',
            'clan_id' => $clan->id,
            'seller_id' => $this->getUser->id,
            'quantity' => 1,
            'price' => $clan->price,
            'balance' => $balance,
            'seen' => 0,
        );
        $new_notification = new Notification($notification_data);
        $new_notification->save();
        return [
            'status' => 1,
            'message' => 'successful',
        ];
    }

    public function updateClan(Request $request, $id)
    {
        $clan = Clan::where('id', $id)->first();
        $clan->title = $request->title;
        $clan->fee = $request->price;
        $clan->save();
        return [
            'status' => 1,
            'message' => 'Clan Updated Successfully',
        ];
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
