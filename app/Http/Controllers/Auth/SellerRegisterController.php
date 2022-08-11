<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
//use Request;
use App\Models\Seller;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use Validator, Input, Redirect;
use App\Traits\CustomFileTrait;



class SellerRegisterController extends Controller
{
    use CustomFileTrait;
    protected $path = '';

    public function __construct()
    {
        $this->path = public_path(config('constant.file_path.store'));
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */

    public function showRegistrationForm()
    {
        return view('auth.seller.register');
    }

    public function approval()
    {
        return view('auth.seller.approval');
    }

    // public function showLoginForm()
    // {
    //     return view('auth.seller.login');
    // }

    public function register(Request $request)
    {


      $validator = Validator::make($request->all(),[
                 "firstname" => 'required|max:255',
                 'email'         => 'required|max:255',
                 'password'     => 'required|max:255',
                 'telephone'     => 'required|max:10',
                 'store_name'         => 'required|max:255',
                 'store_address'      => 'required',
                 'store_logo'  => 'required',
                 'store_state' => 'required',
                 'store_zipcode' => 'required',
              ]);

        if($validator->fails()) {
          return redirect()->back()->withErrors($validator)->withInput();
        }

        $this->createDirectory($this->path);
        if(isset($request->store_logo) && $request->store_logo != ''){
            $request->store_logo = $this->saveCustomFileAndGetImageName(request()->file('store_logo'),$this->path);
        }
        if(isset($request->store_banner) && $request->store_banner != ''){
            $request->store_logo = $this->saveCustomFileAndGetImageName(request()->file('store_banner'),$this->path);
        }

        $inputArray = array(
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telephone' => $request->telephone,
            'store_name' => $request->store_name,
            'store_phone' => $request->store_phone,
            'store_logo' => $request->store_logo,
            'store_banner' => $request->store_banner,
            'store_address' => $request->store_address,
            'store_country' => $request->store_country,
            'store_state' => $request->store_state,
            'store_city' => $request->store_city,
            'store_zipcode' => $request->store_zipcode,
            'store_meta_keywords' => $request->store_meta_keywords,
            'store_meta_description' => $request->store_meta_description,
            'store_seo' => $request->store_seo,
            'facebook_link' => $request->facebook_link,
            'google_link' => $request->google_link,
            'twitter_link' => $request->twitter_link,
            'instagram_link' => $request->instagram_link,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        );

        //DB::enableQueryLog();
        $seller = DB::insert('insert into sellers (firstname, lastname, email, password, telephone, store_name, store_phone, store_logo, store_banner, store_address, store_country, store_state, store_city, store_zipcode, store_meta_keywords, store_meta_description, store_seo, facebook_link, google_link, twitter_link, instagram_link,created_at, updated_at) values (?, ?, ?, ? ,?, ?, ?, ? ,?, ?, ?, ?, ?, ?, ?, ? , ?, ?, ?, ? ,?, ?, ?)', [$inputArray['firstname'], $inputArray['lastname'], $inputArray['email'], $inputArray['password'], $inputArray['telephone'], $inputArray['store_name'], $inputArray['store_phone'], $inputArray['store_logo'], $inputArray['store_banner'], $inputArray['store_address'], $inputArray['store_country'], $inputArray['store_state'], $inputArray['store_city'], $inputArray['store_zipcode'], $inputArray['store_meta_keywords'], $inputArray['store_meta_description'], $inputArray['store_seo'], $inputArray['facebook_link'], $inputArray['google_link'], $inputArray['twitter_link'], $inputArray['instagram_link'], $inputArray['created_at'], $inputArray['updated_at']]);
        //dd(DB::getQueryLog());
        // if registration success then return with success message
        if (!is_null($seller)) {
            return redirect()->route('approval')->with('success', 'You have registered successfully.');
        }

        // else return with error message
        else {
            return back()->with('error', 'Whoops! some error encountered. Please try again.');
        }
        // dd($request->firstname);
        // $this->validator($request->all())->validate();

        // event(new Registered($user = $this->create($request->all())));

        // $this->guard()->login($user);

        // if ($response = $this->registered($request, $user)) {
        //     return $response;
        // }

        // return $request->wantsJson()
        //             ? new JsonResponse([], 201)
        //             : redirect($this->redirectPath());
    }

    // public function sellerLogin(Request $request, Seller $seller)
    // {

    //     $rules = array(
    //         'email' => 'required|email', // make sure the email is an actual email
    //         'password' => 'required|string|min:6',
    //     );

    //     $validator = Validator::make(Request::all(), $rules);
    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator) // send back all errors to the login form
    //             ->with('error', 'login')->withInput(Request::except('password')); // send back the input (not the password) so that we can repopulate the form
    //     }

    //     $userdata = array(
    //         'email' => Request::get('email'),
    //         'password' => Request::get('password'),
    //     );

    //     if (Auth::guard('seller')->attempt($userdata)) {

    //         Session::put('sellerDetail', $seller->find(Auth::guard('seller')->id()));
    //         return redirect()->intended('home');

    //     } else {
    //         // validation not successful, send back to form
    //         return redirect()->back()->with('error', ['msg' => 'Email or Password is wrong!!', 'type' => 'login']);
    //     }
    // }

    // public function DoMemberLogin(Request $request, Member $member)
    // {

    //     // Creating Rules for Email and Password
    //     $rules = array(
    //         'email' => 'required|email', // make sure the email is an actual email
    //         'password' => 'required|string|min:6');
    //     // password has to be greater than 3 characters and can only be alphanumeric and);
    //     // checking all field

    //     $validator = Validator::make(Input::all(), $rules);

    //     // if the validator fails, redirect back to the form

    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator) // send back all errors to the login form
    //             ->with('error', 'login')->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
    //     }
    //     $userdata = array(
    //         'email' => Input::get('email'),
    //         'password' => Input::get('password'),
    //     );
    //     // attempt to do the login
    //     if (Auth::guard('member')->attempt($userdata)) {
    //         Session::put('memberDetail', $member->find(Auth::guard('member')->id()));
    //         // validation successful
    //         // do whatever you want on success

    //         // /  Session::put('memberDetail',)
    //         return redirect()->back();
    //     } else {
    //         // validation not successful, send back to form
    //         return redirect()->back()->with('error', ['msg' => 'Email or Password is wrong!!', 'type' => 'login']);
    //     }
    // }
}
