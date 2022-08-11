<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
//use Illuminate\Http\Request;
use Request;
use App\Models\Seller;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use Validator, Input, Redirect;

class SellerLoginController extends Controller
{

    public function __construct()
    {
      //  $this->middleware('guest:seller')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.seller.login');
    }

    public function sellerLogin(Request $request, Seller $seller)
    {

        $rules = array(
            'email' => 'required|email', // make sure the email is an actual email
            'password' => 'required|string|min:6',
        );

        $validator = Validator::make(Request::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator) // send back all errors to the login form
                ->with('error', 'login')->withInput(Request::except('password')); // send back the input (not the password) so that we can repopulate the form
        }

        $userdata = array(
            'email' => Request::get('email'),
            'password' => Request::get('password'),
        );

        // if (Auth::guard('seller')->attempt($userdata)) {

        //     Session::put('sellerDetail', $seller->find(Auth::guard('seller')->id()));
        //     return redirect()->intended('home');

        // } else {
        //     // validation not successful, send back to form
        //     return redirect()->back()->with('error', ['msg' => 'Email or Password is wrong!!', 'type' => 'login']);
        // }

        if (Auth::guard('seller')->attempt($userdata)) {
          //  Session::put('sellerDetail', $seller->find(Auth::guard('seller')->id()));

            return redirect('seller/sellerDashboard');
        } else {
            return redirect()->back()->with('error', ['msg' => 'Email or Password is wrong!!', 'type' => 'login']);
        }
    }


    public function sellerlogout(){
          Auth::guard('seller')->logout();
          return redirect('seller');

    }
}
