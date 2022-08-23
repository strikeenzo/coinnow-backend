<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderHistory;
use App\Models\Shipping;
use App\Models\StoreProductOption;
use Validator;
use File;
use DB;
use Auth;
use Carbon\Carbon;

class CartApiController extends Controller
{
  private $getUser;
  public function __construct()
  {
    $this->middleware(function ($request, $next) {
        $this->getUser = Auth::guard('customer')->user();
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

              //get getCustomerCart
              $getCustomerCart =   DB::table('cart')->where('customer_id',$this->getUser->id)->where('product_id',$request->product_id)->first();

                //if already product in cart then update
                if($getCustomerCart) {

                  $qty =  $getProduct->quantity + $getCustomerCart->quantity;

                  // check stock
                  if($qty >= $request->quantity) {

                    //update
                    DB::table('cart')->where('cart_id',$getCustomerCart->cart_id)
                    ->update(['quantity' => $getCustomerCart->quantity + $request->quantity,'option' =>$request->options]);

                    //increment product quantity
                    Product::where('id',$getCustomerCart->product_id)->update(['quantity' => $qty]);

                    //decrement product quantity
                    $minusQty = $getCustomerCart->quantity + $request->quantity;
                    Product::where('id',$request->product_id)
                    ->update(['quantity' => $qty - $minusQty]);

                    $cartCount = DB::table('cart')->where('customer_id',$this->getUser->id)->sum('quantity');

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

                  DB::table('cart')->insert(['product_id' => $request->product_id,'customer_id' => $this->getUser->id,'quantity' => $request->quantity,'date_added'=> date('Y-m-d H:i:s'),
                  'option' =>$request->options ]);

                  //decrement product quantity
                  Product::where('id',$request->product_id)->update(['quantity' => $getProduct->quantity - $request->quantity]);

                  $cartCount = DB::table('cart')->where('customer_id',$this->getUser->id)->sum('quantity');

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
            $getCart = DB::table('cart')->where('customer_id',$this->getUser->id)->get();
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
              ->where('cart.customer_id',$this->getUser->id)
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
        $cartCount = DB::table('cart')->where('customer_id',$this->getUser->id)->sum('quantity');
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

    public function getCheckoutData(){
        try {
          $data = [];
          $data['shippingMethods'] = Shipping::where('status',1)->get();
          $data['addresses'] = DB::table('customer_address')->join('country','country.id','=','customer_address.country_id')->select('customer_address.*','country.name as country')->where('customer_id',$this->getUser->id)->get();
          $data['countries'] = Country::where('status','1')->select('id','name','iso_code_3','postcode_required','status')->orderBy('name','ASC')->get();
          return ['status'=> 1, 'data' => $data];
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
          $getMaxNumber = Order::max('id');
          $getAddress = DB::table('customer_address')->whereId($request->address_id)->first();

          $oaymentMethod = '';
          if($request->payment_method  == 'creditCard') {
              $paymentMethod = 'Credit/Debit Card';
          }
          else if($request->payment_method == 'cod') {
             $paymentMethod = 'Cash On Delivery';
          }

          //build order array
          $orderArr = [
                'invoice_no' => $getMaxNumber,
                'customer_id' => $this->getUser->id,
                'seller_id' => $request->seller_id,
                'firstname' => $this->getUser->firstname,
                'lastname' => $this->getUser->lastname,
                'email' => $this->getUser->email,
                'telephone' => $this->getUser->telephone,
                'order_date'=>date('Y-m-d'),
                'shipping_name' => $sessionCartData['shipping']['name'],
                'shipping_address_1' => $getAddress->address_1,
                'shipping_address_2' => $getAddress->address_2,
                'shipping_city' => $getAddress->city,
                'shipping_postcode' => $getAddress->postcode,
                'shipping_country_id' => $getAddress->country_id,
                'comment' => $request->comment,
                'total' =>str_replace(",","", $sessionCartData['subTotal']) ,
                'order_status_id' => '1',
                'tax_amount' => array_key_exists('taxes',$sessionCartData) ?  $sessionCartData['taxes']  ? count($sessionCartData['taxes'] ) > 0 ? $sessionCartData['taxes']['taxAmount'] : 0 : 0 : 0,
                'discount' => array_key_exists('discount',$sessionCartData) ?  $sessionCartData['discount'] ? count($sessionCartData['discount']) > 0 ? $sessionCartData['discount']['discountAmt'] : 0 : 0 : 0,
                'shipping_charge' => $sessionCartData['shipping']['charges'],
                'grand_total' => $sessionCartData['grandTotal'],
                'payment_method' => $paymentMethod,
                'transaction_id' => $request->transaction_id
          ];

          //create order
          $storeOrder = Order::create($orderArr);
          if($storeOrder) {

              //Store OrderProduct
              $storeOrderProductArr = [];
              foreach ($sessionCartData['cartData'] as $key => $value) {
                $storeOrderProductArr[] = [
                    'order_id' => $storeOrder->id,
                    'product_id' => $value['id'],
                    'name' => $value['name'],
                    'quantity' => $value['quantity'],
                    'image' => $value['image'],
                    'price' => str_replace(",","", $value['price']),
                    'special' =>str_replace(",","", $value['special']) ,
                    'total' => str_replace(",","", $value['totalPrice'])
                ];
              }

              OrderProduct::insert($storeOrderProductArr);

              //add order history
              OrderHistory::create([
                  'order_id' => $storeOrder->id,
                  'order_status_id' => '1',
                  'notif' => 0,
                  'comment' => 'Initial Order'
              ]);

              session()->forget('cart'.$this->getUser->id);

              DB::table('cart')->where('customer_id',$this->getUser->id)->delete();

              return ['status'=> 1,'message'=>'Order successfully placed!','orderID' => $storeOrder->id];
          }
          else {
            return ['status'=> 0,'message'=>'Error when order try again later!'];
          }
        //
       } catch (\Exception $e) {
         return ['status'=> 0,'message'=>'Error'];
       }

    }

    public function getOrdersList() {
     try {

        $getOrders = Order::with('orderStatus:name,id','products:name,quantity,image,order_id,product_id,total')
        ->where('customer_id',$this->getUser->id)->orderBy('order.order_date','DESC')->paginate($this->defaultPaginate);
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
