<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Customer;
use App\Models\Product;
use Validator;
use Carbon\Carbon;
use File;
use Response;
use Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Support\Facades\Input;
use Auth;
use DB;

class ApiAuthController extends Controller
{
  private $apiToken;
  public function __construct()
  {
      $this->apiToken = uniqid(base64_encode(Str::random(10)));
  }

  public function register(Request $request) {

     $validator = Validator::make($request->all(),[
            'firstname'          => 'required|regex:/^[\pL\s\-]+$/u',
            'email'         => 'required|unique:customer,email',
            'telephone'     => 'required',
            'password'      => 'required|min:4',
         ]
       );

       if ($validator->fails())
       {
         $message = $this->one_validation_message($validator);
           return ['status' => 0 , 'message' => $message];
       }
       else {
         $data = new Customer($request->only('firstname','lastname','email','telephone','creation'));
         $data->password = bcrypt($request->password);

       if($data->save()) {
          return ['status' => 1 , 'message' =>"Customer created!"];
        }
        else {
            return ['status' => 0 , 'message' =>"Error When create"];
        }

     }
  }

  public function login(Request $request)
  {
        $validator = Validator::make($request->all(),[
             'email'         => 'required',
             'password'      => 'required',
          ]
        );

        if ($validator->fails())
        {
          $message = $this->one_validation_message($validator);
            return ['status' => 0 , 'message' => $message];
        }

        else {
              $customer = Customer::select('id','email','image','image','firstname','lastname','telephone','creation')->where('email',$request->email)->first();
              if($customer)
              {
                $data = array('email'=>$request->email,'password'=>$request->password);
                if (Auth::guard('customer')->attempt($data)) {
                  $wishlistData = DB::table("wishlist")->where('customer_id',$customer->id)->pluck('product_id');
                  $cartCount = DB::table("cart")->where('customer_id',$customer->id)->sum('quantity');
                  return ['status' => 1 ,'wishlistData' => $wishlistData,'cartCount' => $cartCount, 'message' => "Customer successfully login", 'data' => $customer];
                }
                else
                {
                    return ['status' => 0 ,'message' => 'Email/Password Wrong', 'data' => json_decode('{}')];
                }
              }
              else
              {
                    return ['status' => 0 ,'message' => 'Customer not found', 'data' => json_decode('{}'),'code' => '401'];
              }
        }
  }

  public function socialLogin(Request $request) {

    //check exist
    $findCustomer = Customer::where('email',$request->email)->first();

    //login customer
    if($findCustomer ) {
		if($findCustomer->creation == $request->creation){
			    $validator = Validator::make($request->all(),[
           'email'         => 'required',
           'password'      => 'required',
        ]
      );

      if ($validator->fails())
      {
        $message = $this->one_validation_message($validator);
          return ['status' => 0 , 'message' => $message,'new' => 0];
      }
      else {
            $customer = Customer::select('id','email','image','image','firstname','lastname','telephone','creation')->where('email',$request->email)->first();
            if($customer)
            {
              $data = array('email'=>$request->email,'password'=>$request->password);
              if (Auth::guard('customer')->attempt($data)) {
                  $wishlistData = DB::table("wishlist")->where('customer_id',$customer->id)->pluck('product_id');
                  $cartCount = DB::table("cart")->where('customer_id',$customer->id)->sum('quantity');

                  return ['status' => 1 ,'wishlistData' => $wishlistData,'cartCount' => $cartCount, 'message' => "Customer successfully login", 'data' => $customer,'new' => 0];
              }
              else
              {
                  return ['status' => 0 ,'message' => 'Email/Password Wrong', 'data' => json_decode('{}'),'new' => 0];
              }
            }
            else
            {
                  return ['status' => 0 ,'message' => 'Customer not found', 'data' => json_decode('{}'),'code' => '401','new' => 0];
            }
      }
	}
  	else {
		 return ['status' => 0 ,'message' => 'Customer already exist with other social mail','new' => 0];
	}

    }
    else {
      return ['status' => 0 ,'message' => 'New customer','new' => 1];
    }

  }

  public function socialRegister(Request $request) {

     $validator = Validator::make($request->all(),[
            'firstname'          => 'required|regex:/^[\pL\s\-]+$/u',
            'email'         => 'required|unique:customer,email',
            'telephone'     => 'required',
            'password'      => 'required|min:4',
         ]
       );

       if ($validator->fails())
       {
         $message = $this->one_validation_message($validator);
           return ['status' => 0 , 'message' => $message];
       }
       else {
         $data = new Customer($request->only('firstname','lastname','email','telephone','creation','social_id','image'));
         $data->password = bcrypt($request->password);

       if($data->save()) {
         $sdata = array('email'=>$request->email,'password'=>$request->password);
         if (Auth::guard('customer')->attempt($sdata)) {
             $wishlistData = DB::table("wishlist")->where('customer_id',$data->id)->pluck('product_id');
             $cartCount = DB::table("cart")->where('customer_id',$data->id)->sum('quantity');
             return ['status' => 1 ,'wishlistData' => $wishlistData,'cartCount' => $cartCount, 'message' => "Customer successfully login", 'data' => $data];
        }
        else {
            return ['status' => 0 , 'message' =>"Error When create"];
        }
      }
    }
  }

  public function one_validation_message($validator)
  {
     $validation_messages = $validator->getMessageBag()->toArray();
     $validation_messages1 = array_values($validation_messages);
        $new_validation_messages = [];
        for ($i = 0; $i < count($validation_messages1); $i++)
        {
            $inside_element = count($validation_messages1[$i]);
             for ($j=0; $j < $inside_element; $j++)
             {
               array_push($new_validation_messages,$validation_messages1[$i]);
             }
        }
     return implode(' ',$new_validation_messages[0]);
  }

  public function forgotPassword(Request $request,User $user){
      $email = $request->email;
      if($email) {
        $findUser = $user->where('email',$email)->first();
        if($findUser && $findUser->creation_mode == 'D') {
            $encrypted = Crypt::encryptString($findUser->id);

            $message = [
            'title'     => 'Forgot Password',
            'intro'     => "Please click forgot link to reset password ",
            'link'      => url('forgotPassword/'.$encrypted),
            'confirmation_code' => '',
            'to_email'  => $email,
            'to_name'   => $findUser->firstname.' '.$findUser->lastname,
        ];

          \Mail::send('email.forgotPassword', $message, function($m) use($message) {
              $m->to($message['to_email'], $message['to_name'])
                      ->subject('Forgot Password');
                      $m->from('support@infuzehydration.com','Reset Password');
          });
          return ['status' => 1 , 'message' => 'Check your mail!'];
        }
        else {
          return ['status' => 0 , 'message' => 'User not found!'];
        }
      }
      else {
        return ['status' => 0 , 'message' => 'Email required'];
      }
  }


  public function getForgotPassword($id,User $user) {
    $id = Crypt::decryptString($id);
    $findUser = $user->find($id);
    return view('forgotpassword.index',compact('findUser'));
  }

  public function resetPassword($id,Request $request) {
    $rules = array(
      'password' => 'min:6|required_with:cpassword|same:cpassword',
      'cpassword' => 'min:6'
  );

    $validator = Validator::make(Input::all() , $rules);

    if ($validator->fails())
    {
      return redirect()->back()->withErrors($validator)->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
    }
    else {
      $arr = ['password' => Hash::make($request->password)];
      $update = User::where('id',$id)->update($arr);
      if($update) {
        return redirect()->back()->with('success','Password Updated!');
      }
    }
  }



  public function logout() {
      Auth::guard('customer')->logout();
      return ['status' => 1,'message' => 'successfully logout!'];
  }


}
