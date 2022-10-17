<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use App\Traits\CustomFileTrait;
use Auth;
use DB;
use File;
use Hash;
use Illuminate\Http\Request;
use Validator;

class CustomerApiController extends Controller
{
    private $getUser;
    use CustomFileTrait;
    protected $path = '';

    public function __construct()
    {
        $this->path = public_path(config('constant.file_path.user'));
        $this->middleware(function ($request, $next) {
            $this->getUser = Auth::guard('customer')->user();
            return $next($request);
        });
    }

    public function getCustomerDetails()
    {
        return ['status' => 1, 'data' => $this->getUser];
    }

    public function addAddress(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                'country_id' => 'required|max:10',
                'city' => 'required|max:100',
                'postcode' => 'required|max:10',
                'address_1' => 'required|max:128',
            ]
            );

            if ($validator->fails()) {
                $message = $this->one_validation_message($validator);
                return ['status' => 0, 'message' => $message];
            }

            $storeData = $request->all();
            $storeData['customer_id'] = $this->getUser->id;

            $storeAddress = DB::table('customer_address')->insert($storeData);
            $addresses = DB::table('customer_address')->join('country', 'country.id', '=', 'customer_address.country_id')->select('customer_address.*', 'country.name as country')->where('customer_id', $this->getUser->id)->get();
            return ['status' => 1, 'message' => 'Address added successfully!', 'addresses' => $addresses];
        } catch (\Exception$e) {
            return ['status' => 0, 'message' => 'Error'];
        }
    }

    public function editAddress($id, Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                'country_id' => 'required|max:10',
                'city' => 'required|max:100',
                'postcode' => 'required|max:10',
                'address_1' => 'required|max:128',
            ]
            );

            if ($validator->fails()) {
                $message = $this->one_validation_message($validator);
                return ['status' => 0, 'message' => $message];
            }

            $storeAddress = DB::table('customer_address')->where('id', $id)->update($request->all());
            $addresses = DB::table('customer_address')->join('country', 'country.id', '=', 'customer_address.country_id')->select('customer_address.*', 'country.name as country')->where('customer_id', $this->getUser->id)->get();

            return ['status' => 1, 'message' => 'Address updated successfully!', 'addresses' => $addresses];
        } catch (\Exception$e) {
            return ['status' => 0, 'message' => 'Error'];
        }

    }

    public function deleteAddress($id)
    {
        try {
            DB::table('customer_address')->where('id', $id)->delete();
            $addresses = DB::table('customer_address')
                ->join('country', 'country.id', '=', 'customer_address.country_id')
                ->select('customer_address.*', 'country.name as country')
                ->where('customer_id', $this->getUser->id)
                ->get();
            return ['status' => 1, 'message' => 'Address deleted successfully!', 'addresses' => $addresses];
        } catch (\Exception$e) {
            return ['status' => 0, 'message' => 'Error'];
        }
    }

    public function updateProfile(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'firstname' => 'required|regex:/^[\pL\s\-]+$/u',
                'telephone' => 'required|max:11',
            ]
            );

            if ($validator->fails()) {
                $message = $this->one_validation_message($validator);
                return ['status' => 0, 'message' => $message];
            }

            $update = Customer::where('id', $this->getUser->id)->update($request->all());
            $getNew = Customer::select('firstname', 'lastname', 'email', 'image', 'creation', 'telephone')->findOrFail($this->getUser->id);
            return ['status' => 1, 'message' => 'Profile updated successfully!', 'data' => $getNew];

        } catch (\Exception$e) {
            return ['status' => 0, 'message' => 'Error'];
        }

    }

    public function addUpdateWishlist(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'product_id' => 'required|max:11',
            ]
            );

            if ($validator->fails()) {
                $message = $this->one_validation_message($validator);
                return ['status' => 0, 'message' => $message];
            }

            $find = DB::table('wishlist')->where('product_id', $request->product_id)->where('customer_id', $this->getUser->id)->first();
            $msg = '';
            if ($find) {
                DB::table('wishlist')->whereId($find->id)->delete();
                $msg = 'Product successfully removed from wishlist!';
            } else {
                DB::table('wishlist')->insert([
                    'customer_id' => $this->getUser->id,
                    'product_id' => $request->product_id,
                ]);
                $msg = 'Product successfully added to wishlist!';
            }

            $wishlistData = DB::table('wishlist')->where('customer_id', $this->getUser->id)->get();
            return ['status' => 1, 'message' => $msg, 'wishlistData' => $wishlistData];

        } catch (\Exception$e) {
            return ['status' => 0, 'message' => 'Error'];
        }
    }

    //wishlist data
    public function getWishlist()
    {
        try {
            $productID = [];
            $productID = DB::table('wishlist')->where('customer_id', $this->getUser->id)->pluck('product_id');

            $wishlistData = Product::select('id', 'image', 'price', 'quantity', 'sort_order', 'status')
                ->with('productDescription:name,id,product_id', 'special:product_id,price,start_date,end_date')
                ->orderBy('product.sort_order', 'ASC')
                ->whereIn('product.id', $productID)
                ->get();

            return ['status' => 1, 'data' => $wishlistData];
        } catch (\Exception$e) {
            return ['status' => 0, 'message' => 'Error'];
        }
    }

    public function changePassword(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
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
                $customer = Customer::find($this->getUser->id);
                $customer->password = Hash::make($request->new_password);
                $customer->save();
                return ['status' => 1, 'message' => 'Password successfully changed'];
            } else {
                return ['status' => 0, 'message' => 'Current password wrong!'];
            }
        } catch (\Exception$e) {
            return ['status' => 0, 'message' => 'Error'];
        }
    }

    public function changeProfilePicture(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'image' => 'required|image|mimes:jpeg,jpg,png|max:512',
            ]
            );

            if ($validator->fails()) {
                $message = $this->one_validation_message($validator);
                return ['status' => 0, 'message' => $message];
            }

            $this->createDirectory($this->path);
            $imageName = $this->saveCustomFileAndGetImageName(request()->file('image'), $this->path);
            Customer::whereId($this->getUser->id)->update(['image' => $imageName]);
            $getNew = Customer::select('firstname', 'lastname', 'email', 'telephone', 'image', 'creation')->findOrFail($this->getUser->id);
            return ['status' => 1, 'message' => 'Profile image uploaded!', 'data' => $getNew];

        } catch (\Exception$e) {
            return ['status' => 0, 'message' => 'Error'];
        }

    }

    //add review
    public function addReview(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'text' => 'required',
                'rating' => 'required',
            ]
            );

            if ($validator->fails()) {
                $message = $this->one_validation_message($validator);
                return ['status' => 0, 'message' => $message];
            }

            $find = DB::table('review')->where('customer_id', $this->getUser->id)->where('product_id', $request->product_id)->first();

            if ($find) {
                DB::table('review')
                    ->where('customer_id', $this->getUser->id)
                    ->where('product_id', $request->product_id)
                    ->update([
                        'product_id' => $request->product_id,
                        'customer_id' => $this->getUser->id,
                        'text' => $request->text,
                        'rating' => $request->rating,
                    ]);
            } else {
                DB::table('review')->insert([
                    'product_id' => $request->product_id,
                    'customer_id' => $this->getUser->id,
                    'author' => 'admin',
                    'text' => $request->text,
                    'rating' => $request->rating,
                    'status' => '1',
                ]);
            }
            return ['status' => 1, 'message' => 'Review successfully submited!'];

        } catch (\Exception$e) {
            return ['status' => 0, 'message' => 'Error'];
        }
    }

    // get address
    public function getAdress()
    {
        try {
            $address = DB::table('customer_address')
                ->select('customer_address.*', 'country.name as country')
                ->join('country', 'country.id', '=', 'customer_address.country_id')
                ->where('customer_id', $this->getUser->id)
                ->get();

            $countires = Country::where('status', '1')->select('id', 'name', 'iso_code_3', 'postcode_required', 'status')->orderBy('name', 'ASC')->get();
            return ['status' => 1, 'data' => $address, 'countries' => $countires];
        } catch (\Exception$e) {
            return ['status' => 0, 'message' => 'Error'];
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
