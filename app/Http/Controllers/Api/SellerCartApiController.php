<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\ProductDescription;
use App\Models\ProductDiscount;
use App\Models\ProductImage;
use App\Models\ProductRelated;
use App\Models\ProductRelatedAttribute;
use App\Models\ProductSpecial;
use App\Models\Seller;
use App\Models\Special;
use Illuminate\Http\Request;
use App\User;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderHistory;
use App\Models\ProductSellerRelation;
use App\Models\Shipping;
use App\Models\StoreProductOption;
use Illuminate\Support\Facades\Log;
use Validator;
use File;
use DB;
use Auth;
use Carbon\Carbon;

class SellerCartApiController extends Controller
{
  private $getUser;
  public function __construct()
  {
    $this->middleware(function ($request, $next) {
        $this->getUser = Auth::guard('seller')->user();
        return $next($request);
      });
  }

    //addToCart api
    public function addToCart(Request $request) {

      try {

          $getProduct = Product::findOrFail($request->product_id);

          //check product exists or not
          if($getProduct) {

              //check this product already in cart

              $getSellerCart =   DB::table('cart')->where('seller_id',$this->getUser->id)->where('product_id',$request->product_id)->first();

                //if already product in cart then update
                if($getSellerCart) {

                  $qty =  $getProduct->quantity + $getSellerCart->quantity;

                  // check stock
                  if($qty >= $request->quantity) {

                    //update
                    DB::table('cart')->where('cart_id',$getSellerCart->cart_id)
                    ->update(['quantity' => $getSellerCart->quantity + $request->quantity,'option' =>$request->options]);

                    //increment product quantity
                    Product::where('id',$getSellerCart->product_id)->update(['quantity' => $qty]);

                    //decrement product quantity
                    $minusQty = $getSellerCart->quantity + $request->quantity;
                    Product::where('id',$request->product_id)
                    ->update(['quantity' => $qty - $minusQty]);

                    $cartCount = DB::table('cart')->where('seller_id',$this->getUser->id)->sum('quantity');

                    return ['status'=> 1,'message'=>'Product Added To Cart!','cartCount' => $cartCount];

                  }
                  else {
                    return ['status'=> 0,'message'=>'Only ' .$getProduct->quantity. ' products in stock'];
                  }

              }

              //insert product to cart
              else {

                // check stock
                if($getProduct->quantity >= $request->quantity) {

                  DB::table('cart')->insert(['product_id' => $request->product_id,'seller_id' => $this->getUser->id,'quantity' => $request->quantity,'date_added'=> date('Y-m-d H:i:s'),
                  'option' =>$request->options ]);

                  //decrement product quantity
                  Product::where('id',$request->product_id)->update(['quantity' => $getProduct->quantity - $request->quantity]);

                  $cartCount = DB::table('cart')->where('seller_id',$this->getUser->id)->sum('quantity');

                  return ['status'=> 1,'message'=>'Product Added To Cart!','cartCount' => $cartCount];
                }
                else {
                  return ['status'=> 0,'message'=>'Only ' .$getProduct->quantity. ' products in stock'];
                }

              }
            }

            else {
              return ['status'=> 0,'message'=>'Product not found!'];
            }

      } catch (\Exception $e) {
        return ['status'=> 0,'message'=>'Error'];
      }
    }

    //get cart
    public function getCart() {

         try {

            // get cart products
            $getCart = DB::table('cart')->where('seller_id',$this->getUser->id)->get();
            if(count($getCart) > 0 ) {
              $getProducts = Product::select('product.price','product.id','product.model','product.image','cart.quantity','cart.cart_id',
                'product_description.name','tax_rate.rate','tax_rate.type','tax_rate.name as taxName','tax_rate.status as taxStatus',
                'product_special.price as specialPrice','product_special.start_date','product_special.end_date','cart.option'
                )
              ->join('cart','cart.product_id','=','product.id')
              ->join('product_description','product_description.product_id','=','product.id')
              ->leftjoin('tax_rate','tax_rate.id','=','product.tax_rate_id')
              ->leftjoin('product_special','product_special.product_id','=','product.id')
              ->orderBy('cart.date_added','DESC')
              ->where('cart.seller_id',$this->getUser->id)
              ->get();

              $cartData = [];
              $cartTotal = 0.00;
              $subTotal = [];
              $taxRates = [];
              $grandTotal = 0.00;
              $discount = null;
              $taxAMT = 0.00;
              $basePrice = 0.00;
              $optionSum =0 ;
              //build cart with with sub total and total
              foreach ($getProducts as $key => $value) {

                $finalPrice = $value->price;
                $basePrice = $value->price;
                $specialPrice = 0;
                $optionSum = 0;

                if($value->specialPrice) {
                  if($value->start_date  <= date('Y-m-d') && $value->end_date >= date('Y-m-d')) {
                      $specialPrice  = $value->specialPrice;
                      $finalPrice = $value->specialPrice;
                      $basePrice = $value->specialPrice;
                  }
                }

                //check options
                $decodeOptions = json_decode($value->option);

                if($decodeOptions != null) {
                  $optionIDArr = [$decodeOptions->optionColorSelected,$decodeOptions->optionSizeSelected,$decodeOptions->optionSelectSelected];

                  //get Optoins Price
                  $optionSum = StoreProductOption::whereIn('product_option_id',$optionIDArr)->sum('price');
                  if($optionSum > 0) {
                      $finalPrice += (float) $optionSum;
                  }
                }

                $cartTotal += (float) $finalPrice * $value->quantity;
                $grandTotal += (float) $finalPrice * $value->quantity;
                $finalPrice  = $value->quantity * (float) $finalPrice;
                $cartData[] =[
                    'cart_id' => $value->cart_id,
                    'name' => $value->name,
                    'price' =>   $optionSum > 0 ?  number_format($basePrice+$optionSum,2) : number_format($value->price,2),
                    'quantity' => $value->quantity,
                    'image' => $value->image,
                    'id' => $value->id,
                    'totalPrice' => $finalPrice,
                    'special' => number_format($specialPrice,2),
                    'taxStatus' => $value->taxStatus,
                    'taxType' => $value->type,
                    'rate' => $value->rate,
                    'taxName' => $value->taxName
                ];

                //check tax applied or not
                if($value->taxStatus && $value->taxStatus == 1) {
                  if($value->type == 1) {
                      $taxAmount = $finalPrice  / 100 * $value->rate;
                  }
                  else {
                      $taxAmount = $finalPrice  +  $value->rate;
                  }
                  $taxAMT  += $taxAmount;
                //  $taxRates[] = ['name' => $value->taxName,'taxAmount' => $taxAmount ];
                }
              }

              $subTotal[] = ['subTotal' =>$cartTotal];
              $taxRates = ['name' => 'Taxes','taxAmount' => $taxAMT ];

              //you can use seprate tax arr
              // if(count($taxRates) > 0) {
              //
              //   $taxRates =  $this->mergeTax($taxRates);
              //
              //   foreach ($taxRates as $key => $value) {
              //       $grandTotal +=  $value['taxAmount'];
              //   }
              // }

              $grandTotal +=  $taxAMT;
              $grandTotal = number_format($grandTotal,2);

              //store cart in session
              session()->put('cart'.$this->getUser->id,['cartData' => $cartData,'subTotal' =>number_format($cartTotal,2) ,'discount' => $discount,'taxes' => $taxRates,'grandTotal' => $grandTotal,'products' => $getProducts]);
              session()->save();
              return ['status'=> 1,'cartData' => $cartData,'subTotal' =>number_format($cartTotal,2) ,'discount' => $discount,'taxes' => $taxRates,'grandTotal' => $grandTotal];

            }
            else{
              return ['status'=> 0,'cartData'=>[]];
            }

          } catch (\Exception $e) {
            return ['status'=> 0,'message'=>'Error'];
          }
    }

    //update cart
    public function updateCart(Request $request) {

       try {
        //get cart
        $getCart =   DB::table('cart')->where('cart_id',$request->cart_id)->first();
        if($getCart) {

          //get product
          $getProduct = Product::findOrFail($getCart->product_id);

          $qty =  $getProduct->quantity + $getCart->quantity;

          // check stock
          if($qty >= $request->quantity) {

            //update
            DB::table('cart')->where('cart_id',$getCart->cart_id)->update(['quantity' => $request->quantity]);

            //increment product quantity
            Product::where('id',$getCart->product_id)->update(['quantity' => $qty]);

            //decrement product quantity
            $minusQty = $getCart->quantity + $request->quantity;

            Product::where('id',$getCart->product_id)
            ->update(['quantity' => $qty - $request->quantity]);

            //build cart
           return  $this->buildCart($request->all(),'update');

          }
          else {
            return ['status'=> 0,'message'=>'Only ' .$getProduct->quantity. ' products in stock'];
          }
        }
        else {
          return ['status'=> 0,'message'=>'Error'];
        }

      } catch (\Exception $e) {
        return ['status'=> 0,'message'=>'Error'];
      }
    }

    //update cart
    public function deleteCart(Request $request) {

        //get cart
        $getCart =   DB::table('cart')->where('cart_id',$request->cart_id)->first();
        if($getCart) {
            //get product
            $getProduct = Product::findOrFail($getCart->product_id);

            $qty =  $getProduct->quantity + $getCart->quantity;

            //update
            DB::table('cart')->where('cart_id',$getCart->cart_id)->delete();

            //increment product quantity
            Product::where('id',$getCart->product_id)->update(['quantity' => $qty]);

            //build cart
           return  $this->buildCart($request->all(),'delete');
         }
         else {
           return ['status'=> 0,'message'=>'Error'];
         }
    }

    public function buildCart($postData,$cartType) {

        $sessionCartData = session()->get('cart'.$this->getUser->id);
        $getProducts = $sessionCartData['products'];

        $cartData = [];
        $cartTotal = 0.00;
        $subTotal = [];
        $taxRates = [];
        $grandTotal = 0.00;
        $discount = null;
        $taxAMT = 0.00;
        $basePrice =0.00;
        //build cart with with sub total and total
        foreach ($getProducts as $key => $value) {

          $optionSum = 0;

        /******************************************************
        **********if cart build for update**********************
        *******************************************************/
        if($cartType == 'update') {
          $quantity = $value->quantity;
          if($value->cart_id == $postData['cart_id'] ) {
            $quantity = $postData['quantity'];
          }

          $finalPrice = $value->price;
          $basePrice =  $value->price;

          $specialPrice = 0;
          if($value->specialPrice) {
            if($value->start_date  <= date('Y-m-d') && $value->end_date >= date('Y-m-d')) {
                $specialPrice  = $value->specialPrice;
                $finalPrice = $value->specialPrice;
                $basePrice = $value->specialPrice;
            }
          }

          //check options
          $decodeOptions = json_decode($value->option);

          if($decodeOptions != null) {
            $optionIDArr = [$decodeOptions->optionColorSelected,$decodeOptions->optionSizeSelected,$decodeOptions->optionSelectSelected];

            //get Optoins Price
            $optionSum = StoreProductOption::whereIn('product_option_id',$optionIDArr)->sum('price');

            if($optionSum > 0) {
                $finalPrice += (float) $optionSum;
            }
          }

          $cartTotal += (float) $finalPrice * (int) $quantity;
          $grandTotal += (float) $finalPrice * (int) $quantity;

          $finalPrice  = (int) $quantity * (float) $finalPrice;

          $cartData[] =[
              'cart_id' => $value->cart_id,
              'name' => $value->name,
              'price' =>   $optionSum > 0 ?  number_format($basePrice+$optionSum,2) : number_format($value->price,2),
              'quantity' => $quantity,
              'image' => $value->image,
              'id' => $value->id,
              'totalPrice' => $finalPrice,
              'special' => number_format($specialPrice,2),
              'taxStatus' => $value->taxStatus,
              'taxType' => $value->type,
              'rate' => $value->rate,
              'taxName' => $value->taxName
          ];

          //check tax applied or not
          if($value->taxStatus && $value->taxStatus == 1) {
            if($value->type == 1) {
                $taxAmount = $finalPrice  / 100 * $value->rate;
            }
            else {
                $taxAmount = $finalPrice  +  $value->rate;
            }
            $taxAMT  += $taxAmount;
          //  $taxRates[] = ['name' => $value->taxName,'taxAmount' => $taxAmount ];
          }
        }

        /******************************************************
        **********if cart build for delete**********************
        *******************************************************/
        else if($cartType == 'delete') {

          $quantity = $value->quantity;

          if($value->cart_id != $postData['cart_id'] ) {
            $finalPrice =  $value->price;
            $basePrice =  $value->price;

            //check options
            $decodeOptions = json_decode($value->option);

            if($decodeOptions != null) {
              $optionIDArr = [$decodeOptions->optionColorSelected,$decodeOptions->optionSizeSelected,$decodeOptions->optionSelectSelected];

              //get Optoins Price
              $optionSum = StoreProductOption::whereIn('product_option_id',$optionIDArr)->sum('price');

              if($optionSum > 0) {
                  $finalPrice += (float) $optionSum;
              }
            }

            $specialPrice = 0;
            if($value->specialPrice) {
              if($value->start_date  <= date('Y-m-d') && $value->end_date >= date('Y-m-d')) {
                  $specialPrice  = $value->specialPrice;
                  $finalPrice = $value->specialPrice;
                  $basePrice =  $value->specialPrice;

              }
            }

            $cartTotal += (float) $finalPrice * $quantity;
            $grandTotal += (float) $finalPrice * $quantity;

            $finalPrice  = (int) $quantity * (float) $finalPrice;

            $cartData[] =[
                'cart_id' => $value->cart_id,
                'name' => $value->name,
                'price' =>   $optionSum > 0 ?  number_format($basePrice+$optionSum,2) : number_format($value->price,2),
                'quantity' => $quantity,
                'image' => $value->image,
                'id' => $value->id,
                'totalPrice' => $finalPrice,
                'special' => number_format($specialPrice,2),
                'taxStatus' => $value->taxStatus,
                'taxType' => $value->type,
                'rate' => $value->rate,
                'taxName' => $value->taxName
            ];

            //check tax applied or not
            if($value->taxStatus && $value->taxStatus == 1) {
              if($value->type == 1) {
                  $taxAmount = $finalPrice  / 100 * $value->rate;
              }
              else {
                  $taxAmount = $finalPrice  +  $value->rate;
              }
              $taxAMT  += $taxAmount;
            }
          }
        }
      }

        $subTotal[] = ['subTotal' =>$cartTotal];
        $taxRates = ['name' => 'Taxes','taxAmount' => $taxAMT ];
        $grandTotal +=  $taxAMT;

        //Again calculate discount
        if($sessionCartData['discount']) {

          //calculate discount
          $discountTxt = '';
          $discountAmt = 0;
          if($sessionCartData['discount']['type'] == 1) {
            $discountAmt = $grandTotal  / 100 * $sessionCartData['discount']['discount'];
            $discountTxt = number_format($sessionCartData['discount']['discount'],2).'%';
          }
          else {
            $discountAmt = $grandTotal  +  $sessionCartData['discount']['discount'];
            $discountTxt = number_format($sessionCartData['discount']['discount'],2);
          }


          $grandTotal -=  $discountAmt;
          $discount = ['name' => $sessionCartData['discount']['name'],'discountAmt' => number_format($discountAmt,2),'type' => $sessionCartData['discount']['type'],'discount' => $sessionCartData['discount']['discount']  ];
        }

        $grandTotal = number_format($grandTotal,2);

        $newSessionData = [
          'cartData' => $cartData,'subTotal' =>$subTotal,
          'discount' => $discount,
          'taxes' => $sessionCartData['taxes'],
          'grandTotal' => $grandTotal,
          'products' => $sessionCartData['products']
        ];

        //store cart in session
        session()->put('cart'.$this->getUser->id,$newSessionData);
        session()->save();
        $cartCount = DB::table('cart')->where('seller_id',$this->getUser->id)->sum('quantity');
        return ['status'=> 1,'cartData' => $cartData,'cartCount'=>$cartCount,'subTotal' =>number_format($cartTotal,2) ,'discount' => $discount,'taxes' => $taxRates,'grandTotal' => $grandTotal];
   }


    //apply coupon
    public function applyCoupon(Request $request) {
       try {
        //check coupon exists
         $getCoupon = DB::table('coupon')->where('code',$request->couponCode)->first();
         $discount = null;
         $taxRates=[];
         $discountAmt = 0.00;

         if($getCoupon) {

           $sessionCartData = session()->get('cart'.$this->getUser->id);

           if(count($sessionCartData) > 0) {
               if(date('Y-m-d',strtotime($getCoupon->start_date)) <= date('Y-m-d') && date('Y-m-d',strtotime($getCoupon->end_date))  >= date('Y-m-d')) {

                   //get sub total
                   $totalAmt  = str_replace(",","", $sessionCartData['grandTotal']);

                   //calculate discount
                   $discountTxt = '';
                   if($getCoupon->type == 1) {
                       $discountAmt = $totalAmt  / 100 * $getCoupon->discount;
                       $discountTxt = number_format($getCoupon->discount,2).'%';
                   }
                   else {
                       $discountAmt = $totalAmt  +  $getCoupon->discount;
                       $discountTxt = number_format($getCoupon->discount,2);
                   }
                   $grandTotal  = str_replace(",","", $sessionCartData['grandTotal']);

                   if($sessionCartData['discount'] ) {
                     if( $sessionCartData['discount']['name'] !=  $request->couponCode.' ('.$discountTxt.')') {
                       $grandTotal = $grandTotal - $discountAmt;
                       $discount = ['name' => $request->couponCode.' ('.$discountTxt.')','discountAmt' => number_format($discountAmt,2)  ];
                       $newSessionData = [
                         'cartData' => $sessionCartData['cartData'],'subTotal' =>$sessionCartData['subTotal'],
                         'discount' => $discount,
                         'taxes' => $sessionCartData['taxes'],
                         'grandTotal' => $grandTotal,
                         'products' => $sessionCartData['products']
                       ];
                       session()->put('cart'.$this->getUser->id,$newSessionData);
                       session()->save();
                     }
                     else {
                        $grandTotal = str_replace(',','',$sessionCartData['grandTotal']);
                        $discount = $sessionCartData['discount'];
                     }
                   }
                   else {
                     $grandTotal = $grandTotal - $discountAmt;
                     $discount = ['name' => $request->couponCode.' ('.$discountTxt.')','discountAmt' => number_format($discountAmt,2),'type' => $getCoupon->type,'discount' => $getCoupon->discount  ];
                     $newSessionData = [
                       'cartData' => $sessionCartData['cartData'],
                       'subTotal' =>$sessionCartData['subTotal'],
                       'discount' => $discount,
                       'taxes' => $sessionCartData['taxes'],
                       'grandTotal' => $grandTotal,
                       'products' => $sessionCartData['products']
                     ];
                     session()->put('cart'.$this->getUser->id,$newSessionData);
                     session()->save();
                   }

                   return ['status'=> 1, 'message' =>"Coupon successfully applied!",'discount' => $discount,'grandTotal' => number_format($grandTotal,2)];
               }
               else {
                 return ['status'=> 0,'message'=>'Coupon expired!'];
               }
             }

           else {
             return ['status'=> 0,'message'=>'Invalid coupon code'];
           }

         }
         else {
           return ['status'=> 0,'message'=>'Invalid coupon code'];
         }
      } catch (\Exception $e) {
        return ['status'=> 0,'message'=>'Error'];
      }

    }

    public function selectShipping($id){

     try {


          $findShipping = Shipping::findOrFail($id);

          //get cart data
          $sessionCartData = session()->get('cart'.$this->getUser->id);
          if($sessionCartData ) {

            if(array_key_exists('shipping',$sessionCartData)) {
              $grandTotal  = str_replace(",","", $sessionCartData['grandTotal']);
              $grandTotal = $grandTotal - $sessionCartData['shipping']['charges'];
              $grandTotal = $grandTotal + $findShipping->shipping_charge;
            }
            else{
              $grandTotal  = str_replace(",","", $sessionCartData['grandTotal']);
              $grandTotal = $grandTotal + $findShipping->shipping_charge;
            }

            $shipping = [
              'name' =>$findShipping->name,
              'charges' => $findShipping->shipping_charge,
              'id' => $findShipping->id
            ];

            $newSessionData = [
              'cartData' => $sessionCartData['cartData'],
              'subTotal' => $sessionCartData['subTotal'],
              'discount' => $sessionCartData['discount'],
              'taxes' => $sessionCartData['taxes'],
              'grandTotal' => $grandTotal,
              'products' => $sessionCartData['products'],
              'shipping' => $shipping
            ];

            session()->put('cart'.$this->getUser->id,$newSessionData);
            session()->save();

            return ['status'=> 1,'shipping' => $shipping,'orderSummary' => $sessionCartData['cartData'],'grandTotal' => number_format($grandTotal,2)];
          }
          else {
            return ['status'=> 1,'message' => 'Session expired add products again!'];
          }
        } catch (\Exception $e) {
          return ['status'=> 0,'message'=>'Error'];
        }
    }

    public function placeOrder(Request $request){
     try {
          $sessionCartData =  session()->get('cart'.$this->getUser->id);
          $balance = $this->getUser->balance;
          if ($balance < $sessionCartData['grandTotal']) {
              return ['status'=> 0,'message'=> 'No enough balance'];
          }

          $cartData = $sessionCartData['cartData'];
         $product_ids = [];
         foreach ($cartData as $key => $value) {
             $product_ids[] = $value['id'];
         }
         foreach ($cartData as $key => $value) {
             $product = Product::where('id', $value['id'])->first();

             if (!empty($product)) {
                $existing_relation = ProductSellerRelation::where('product_id', $product->id)->where('seller_id', $this->getUser->id)->where('sale', 0)->first();
                if (!empty($existing_relation)) {
                  $existing_relation->quantity += $value['quantity'];
                  $existing_relation->sale_date = Carbon::now();
                  $existing_relation->sale = 0;
                  $existing_relation->save();
                } else {
                  ProductSellerRelation::create([
                    'seller_id' => $this->getUser->id,
                    'product_id' => $product->id,
                    'sale' => 0,
                    'quantity' => $value['quantity'],
                  ]);
                }
                //  $existing_product = Product::where('origin_id', $value['origin_id'] ?? $value['id'])->where('seller_id', $this->getUser->id)->where('sale', 0)->first();
                //  if (!empty($existing_product)) {
                //      $quantity = $existing_product->quantity + $value['quantity'];
                //      $existing_product->quantity = $quantity;
                //      $existing_product->sale_date = Carbon::now();
                //      $existing_product->sale = 0;
                //      $existing_product->save();
                //  } else {
                //      $description = ProductDescription::where('product_id', $product->id)->first();
                //      $related_attributes = ProductRelatedAttribute::where('product_id', $product->id)->first();
                //      $product_related = ProductRelated::where('product_id', $product->id)->first();
                //      $product_option = StoreProductOption::where('product_id', $product->id)->first();
                //      $product_special = ProductSpecial::where('product_id', $product->id)->first();
                //      $product_image = ProductImage::where('product_id', $product->id)->first();
                //      $product_discount = ProductDiscount::where('product_id', $product->id)->first();

                //      $new_product_data = array(
                //          'model' => $product->model,
                //          'origin_id' => !empty($product->origin_id) ? $product->origin_id : $product->id,
                //          'seller_id' => $this->getUser->id,
                //          'quantity' => $value['quantity'],
                //          'category_id' => $product->category_id,
                //          'price' => $product->price,
                //          'image' => $product->image,
                //          'option' => $product->option,
                //          'location' => $product->location,
                //          'stock_status_id' => $product->stock_status_id,
                //          'manufacturer_id' => $product->manufacturer_id,
                //          'tax_rate_id' => $product->tax_rate_id,
                //          'date_available' => $product->date_available,
                //          'length' => $product->length,
                //          'width' => $product->width,
                //          'height' => $product->height,
                //          'weight_class_id' => $product->weight_class_id,
                //          'status' => $product->status,
                //          'sort_order' => $product->sort_order,
                //          'sale_date' => Carbon::now(),
                //          'sale' => 0,
                //      );
                //      $new_product = new Product($new_product_data);
                //      $new_product->save();
                //      $notification_data = array(
                //          'type' => 'item_shop_sell',
                //          'product_id' => $product->id,
                //          'quantity' => 1,
                //          'price' => $product->price,
                //          'seen' => 0,
                //      );
                //      $new_notification = new Notification($notification_data);
                //      $new_notification->save();

                //      if (!empty($description) && !empty($new_product)) {
                //          $new_description = $description->replicate();
                //          $new_description->product_id = $new_product->id;
                //          $new_description->save();
                //      }
                //      if (!empty($related_attributes) && !empty($new_product)) {
                //          $new_attributes = $related_attributes->replicate();
                //          $new_attributes->product_id = $new_product->id;
                //          $new_attributes->save();
                //      }
                //      if (!empty($product_related) && !empty($new_product)) {
                //          $new_related = $product_related->replicate();
                //          $new_related->product_id = $new_product->id;
                //          $new_related->save();
                //      }
                //      if (!empty($product_option) && !empty($new_product)) {
                //          $new_option = $product_option->replicate();
                //          $new_option->product_id = $new_product->id;
                //          $new_option->save();
                //      }
                //      if (!empty($product_special) && !empty($new_product)) {
                //          $new_special = $product_special->replicate();
                //          $new_special->product_id = $new_product->id;
                //          $new_special->save();
                //      }
                //      if (!empty($product_image) && !empty($new_product)) {
                //          $new_image = $product_image->replicate();
                //          $new_image->product_id = $new_product->id;
                //          $new_image->save();
                //      }
                //      if (!empty($product_discount) && !empty($new_product)) {
                //          $new_discount = $product_discount->replicate();
                //          $new_discount->product_id = $new_product->id;
                //          $new_discount->save();
                //      }
                // }
             }
         }

         $balance -= $sessionCartData['grandTotal'];
         $this->getUser->update(['balance' => $balance]);

         session()->forget('cart'.$this->getUser->id);

         DB::table('cart')->where('seller_id',$this->getUser->id)->delete();

         return ['status'=> 1,'message'=> "Order successfully placed!",];
        //
       } catch (\Exception $e) {
         Log::info(json_encode($e));

         return ['status'=> 0,'message'=> $e];
       }

    }

    public function buyProduct(Request $request){
        try {
            $product = Product::where('id', $request->id)->with('seller')->first();
            $quantity = $request->quantity;

            $balance = $this->getUser->balance;
            if ($balance < $product->price * $quantity) {
                return ['status'=> 0,'message'=> 'No enough balance'];
            }
            if ($product->quantity < $quantity) {
                return ['status'=> 0,'message'=> '0 items in stock'];
            }
            if (!empty($product)) {
                if ($product->points > 0) {
                    $power = $this->getUser->power ?? 0;
                    $power += $product->points;
                    $this->getUser->update(['power' => $power]);
                    $notification_data = array(
                        'type' => 'special_item_buy',
                        'product_id' => $product->id,
                        'seller_id' => $this->getUser->id,
                        'quantity' => $quantity,
                        'price' => $product->price,
                        'balance' => $balance,
                        'seen' => 0,
                    );
                    $new_notification = new Notification($notification_data);
                    $new_notification->save();

                    $origin_special = Special::where('product_id', $product->origin_id ?? $product->id)->where('seller_id', $this->getUser->id)->first();
                    if (!empty($origin_special)) {
                        $origin_special->quantity = $origin_special->quantity + $quantity;
                        $origin_special->save();
                    } else {
                        $new_special_data = array(
                            'product_id' => $product->id,
                            'seller_id' => $this->getUser->id,
                            'quantity' => $quantity,
                        );
                        $new_special = new Special($new_special_data);
                        $new_special->save();
                    }
                    if (!empty($product->seller)) {
                        $notification_data = array(
                            'type' => 'special_item_sell',
                            'product_id' => $product->id,
                            'seller_id' => $product->seller->id,
                            'quantity' => $quantity,
                            'balance' => $product->seller->balance,
                            'price' => $product->price,
                            'seen' => 0,
                        );
                        $new_notification = new Notification($notification_data);
                        $new_notification->save();
                    }

                } else {
                  $existing_relation = ProductSellerRelation::where('product_id', $product->id)->where('seller_id', $this->getUser->id)->where('sale', 0)->first();
                  if (!empty($existing_relation)) {
                    $existing_relation->quantity += $quantity;
                    $existing_relation->sale_date = Carbon::now();
                    $existing_relation->sale = 0;
                    $existing_relation->save();
                  } else {
                    ProductSellerRelation::create([
                      'seller_id' => $this->getUser->id,
                      'product_id' => $product->id,
                      'sale' => 0,
                      'quantity' => $quantity,
                    ]);
                  }
                  $notification_data = array(
                    'type' => 'item_buy',
                    'product_id' => $product->id,
                    'seller_id' => $this->getUser->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'balance' => $balance,
                    'seen' => 0,
                  );
                  $new_notification = new Notification($notification_data);
                  $new_notification->save();
                  if (!empty($product->seller)) {
                    $notification_data = array(
                        'type' => 'item_sell',
                        'product_id' => $product->id,
                        'seller_id' => $product->seller->id,
                        'quantity' => $quantity,
                        'price' => $product->price,
                        'balance' => $product->seller->balance,
                        'seen' => 0,
                    );
                    $new_notification = new Notification($notification_data);
                    $new_notification->save();
                  }
                }
                if (!empty($product->seller)) {
                    $seller = Seller::where('id', $product->seller->id)->first();
                    $newProfit = $seller->profit + $product->price * $quantity;
                    $newBalance = $seller->balance + $product->price * $quantity;
                    $seller->profit = $newProfit;
                    $seller->balance = $newBalance;
                    $seller->save();
                }
                $this->getUser->update(['balance' => $balance - $product->price * $quantity]);
                $product->quantity = $product->quantity - $quantity;
                $product->save();
            }

            return ['status'=> 1,'message'=> 'successful!',];
            //
        } catch (\Exception $e) {
            Log::info(json_encode($e));

            return ['status'=> 0,'message'=> $e];
        }

    }

    public function fightProduct(Request $request) {
        try {
            $specials = json_decode($request->specials);

            $product = Product::where('id', $request->id)->with('seller')->first();
            if ($product->quantity < 1) {
                return ['status'=> 0,'message'=> '0 items in stock'];
            }
            if ($product->points > 0) {
                return ['status'=> 0,'message'=> 'Can not fight for special items.'];
            }
            if (empty($product) || empty($product->seller)) {
                return ['status'=> 0,'message'=> 'Unable to fight for the product.'];
            }
            $seller_power = $product->seller->power;
            $user_power = 0;
            foreach ($specials as $key=>$special) {
                $user_power+= $special->points * $special->quantity;
            }

            if (!empty($product)) {

                $new_power = $this->getUser->power - $user_power;
                $new_seller_power = $seller_power - $user_power > 0 ? $seller_power - $user_power : 0;
                $this->getUser->update(['power' => $new_power]);
                $seller = Seller::where('id', $product->seller->id)->first();
                $seller->power = $new_seller_power;
                $seller->save();

                foreach($specials as $key => $special) {
                    $special_item = Special::where('product_id', $key)->where('seller_id', $this->getUser->id)->first();
                    $special_item->quantity = $special_item->quantity - $special->quantity;
                    $special_item->save();
                }

                if ($seller_power > $user_power) {
                    return ['status'=> 1,'message'=> 'You lost'];
                }
                $existing_relation = ProductSellerRelation::where('product_id', $product->id)->where('seller_id', $this->getUser->id)->where('sale', 0)->first();
                  if (!empty($existing_relation)) {
                    $existing_relation->quantity += 1;
                    $existing_relation->sale_date = Carbon::now();
                    $existing_relation->sale = 0;
                    $existing_relation->save();
                  } else {
                    ProductSellerRelation::create([
                      'seller_id' => $this->getUser->id,
                      'product_id' => $product->id,
                      'sale' => 0,
                      'quantity' => 1,
                    ]);
                  }
                // $existing_product = Product::where('origin_id', $product->origin_id ?? $product->id)->where('seller_id', $this->getUser->id)->where('sale', 0)->first();
                // if (!empty($existing_product)) {
                //     $quantity = $existing_product->quantity + 1;
                //     $existing_product->quantity = $quantity;
                //     $existing_product->sale_date = Carbon::now();
                //     $existing_product->sale = 0;
                //     $existing_product->save();
                // } else {
                //     $description = ProductDescription::where('product_id', $product->id)->first();
                //     $related_attributes = ProductRelatedAttribute::where('product_id', $product->id)->first();
                //     $product_related = ProductRelated::where('product_id', $product->id)->first();
                //     $product_option = StoreProductOption::where('product_id', $product->id)->first();
                //     $product_special = ProductSpecial::where('product_id', $product->id)->first();
                //     $product_image = ProductImage::where('product_id', $product->id)->first();
                //     $product_discount = ProductDiscount::where('product_id', $product->id)->first();

                //     $new_product_data = array(
                //         'model' => $product->model,
                //         'origin_id' => !empty($product->origin_id) ? $product->origin_id : $product->id,
                //         'seller_id' => $this->getUser->id,
                //         'quantity' => 1,
                //         'category_id' => $product->category_id,
                //         'price' => $product->price,
                //         'image' => $product->image,
                //         'option' => $product->option,
                //         'location' => $product->location,
                //         'stock_status_id' => $product->stock_status_id,
                //         'manufacturer_id' => $product->manufacturer_id,
                //         'tax_rate_id' => $product->tax_rate_id,
                //         'date_available' => $product->date_available,
                //         'length' => $product->length,
                //         'width' => $product->width,
                //         'height' => $product->height,
                //         'weight_class_id' => $product->weight_class_id,
                //         'status' => $product->status,
                //         'sort_order' => $product->sort_order,
                //         'sale_date' => Carbon::now(),
                //         'sale' => 0,
                //     );
                //     $new_product = new Product($new_product_data);
                //     $new_product->save();
                //     if (!empty($description) && !empty($new_product)) {
                //         $new_description = $description->replicate();
                //         $new_description->product_id = $new_product->id;
                //         $new_description->save();
                //     }
                //     if (!empty($related_attributes) && !empty($new_product)) {
                //         $new_attributes = $related_attributes->replicate();
                //         $new_attributes->product_id = $new_product->id;
                //         $new_attributes->save();
                //     }
                //     if (!empty($product_related) && !empty($new_product)) {
                //         $new_related = $product_related->replicate();
                //         $new_related->product_id = $new_product->id;
                //         $new_related->save();
                //     }
                //     if (!empty($product_option) && !empty($new_product)) {
                //         $new_option = $product_option->replicate();
                //         $new_option->product_id = $new_product->id;
                //         $new_option->save();
                //     }
                //     if (!empty($product_special) && !empty($new_product)) {
                //         $new_special = $product_special->replicate();
                //         $new_special->product_id = $new_product->id;
                //         $new_special->save();
                //     }
                //     if (!empty($product_image) && !empty($new_product)) {
                //         $new_image = $product_image->replicate();
                //         $new_image->product_id = $new_product->id;
                //         $new_image->save();
                //     }
                //     if (!empty($product_discount) && !empty($new_product)) {
                //         $new_discount = $product_discount->replicate();
                //         $new_discount->product_id = $new_product->id;
                //         $new_discount->save();
                //     }

                // }
                $notification_data = array(
                    'type' => 'fight_item_buy',
                    'product_id' => $product->id,
                    'seller_id' => $this->getUser->id,
                    'quantity' => 1,
                    'price' => $product->price,
                    'balance' =>  $this->getUser->balance,
                    'seen' => 0,
                );
                $new_notification = new Notification($notification_data);
                $new_notification->save();
                if (!empty($product->seller)) {
                    $notification_data = array(
                        'type' => 'fight_item_sell',
                        'product_id' => $product->id,
                        'seller_id' => $product->seller->id,
                        'quantity' => 1,
                        'price' => $product->price,
                        'balance' =>  $product->seller->balance,
                        'seen' => 0,
                    );
                    $new_notification = new Notification($notification_data);
                    $new_notification->save();
                }
                $product->quantity = $product->quantity - 1;
                $product->save();
            } else {
                return ['status'=> 0,'message'=> 'No product!',];
            }

            return ['status'=> 1,'message'=> 'successful!',];
            //
        } catch (\Exception $e) {
            Log::info(json_encode($e));

            return ['status'=> 0,'message'=> $e];
        }

    }

    public function getOrdersList() {
     try {

        $getOrders = Order::with('orderStatus:name,id','products:name,quantity,image,order_id,product_id,total')
        ->where('seller_id',$this->getUser->id)->orderBy('order.order_date','DESC')->paginate($this->defaultPaginate);
        return ['status'=> 1,'data'=>$getOrders];
      } catch (\Exception $e) {
        return ['status'=> 0,'message'=>'Error'];
      }

    }

    public function mergeTax($taxRates) {

      $finalTaxRates = [];

      //merge same taxes
      $newTaxArr = [];
      foreach($taxRates as $key => $value) {
            $newTaxArr[$value['name']][] = $value['taxAmount'];
      }

      //final tax arr
      foreach($newTaxArr as $key => $value) {
          $finalTaxRates[] = array('name'=>$key,'taxAmount'=>array_sum($value));
      }

      return $finalTaxRates;

    }



  }
