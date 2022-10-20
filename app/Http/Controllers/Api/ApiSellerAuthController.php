<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\UserQuestionRelation;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Validator;

class ApiSellerAuthController extends Controller
{
    private $apiToken;
    public function __construct()
    {
        $this->apiToken = uniqid(base64_encode(Str::random(10)));
    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'firstname' => 'required|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|unique:seller,email',
            'telephone' => 'required|max:255',
            'password' => 'required|min:4',
        ]
        );

        if ($validator->fails()) {
            $message = $this->one_validation_message($validator);
            return ['status' => 0, 'message' => $message];
        } else {
            $data = new Seller($request->only('firstname', 'lastname', 'email', 'telephone', 'store_name', 'status'));
            $data->password = bcrypt($request->password);

            if ($data->save()) {
                return ['status' => 1, 'message' => "Seller created!"];
            } else {
                return ['status' => 0, 'message' => "Error When create"];
            }

        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]
        );

        if ($validator->fails()) {
            $message = $this->one_validation_message($validator);
            return ['status' => 0, 'message' => $message];
        } else {
            $seller = Seller::select('id', 'email', 'firstname', 'lastname', 'telephone', 'store_name', 'balance')->where('email', $request->email)->first();
            if ($seller) {
                $data = array('email' => $request->email, 'password' => $request->password);
                if (Auth::guard('seller')->attempt($data)) {
                    $cartCount = DB::table("cart")->where('seller_id', $seller->id)->sum('quantity');
                    return ['status' => 1, 'wishlistData' => [], 'cartCount' => $cartCount, 'message' => "Seller successfully login", 'data' => $seller];
                } else {
                    return ['status' => 0, 'message' => 'Incorrect Information', 'data' => json_decode('{}')];
                }
            } else {
                return ['status' => 0, 'message' => 'Seller not found', 'data' => json_decode('{}'), 'code' => '401'];
            }
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

    public function forgotPassword(Request $request, User $user)
    {
        $email = $request->email;
        if ($email) {
            $findUser = $user->where('email', $email)->first();
            if ($findUser && $findUser->creation_mode == 'D') {
                $encrypted = Crypt::encryptString($findUser->id);

                $message = [
                    'title' => 'Forgot Password',
                    'intro' => "Please click forgot link to reset password ",
                    'link' => url('forgotPassword/' . $encrypted),
                    'confirmation_code' => '',
                    'to_email' => $email,
                    'to_name' => $findUser->firstname . ' ' . $findUser->lastname,
                ];

                \Mail::send('email.forgotPassword', $message, function ($m) use ($message) {
                    $m->to($message['to_email'], $message['to_name'])
                        ->subject('Forgot Password');
                    $m->from('support@infuzehydration.com', 'Reset Password');
                });
                return ['status' => 1, 'message' => 'Check your mail!'];
            } else {
                return ['status' => 0, 'message' => 'User not found!'];
            }
        } else {
            return ['status' => 0, 'message' => 'Email required'];
        }
    }

    public function getForgotPassword($id, User $user)
    {
        $id = Crypt::decryptString($id);
        $findUser = $user->find($id);
        return view('forgotpassword.index', compact('findUser'));
    }

    public function resetPassword($id, Request $request)
    {
        $rules = array(
            'password' => 'min:6|required_with:cpassword|same:cpassword',
            'cpassword' => 'min:6',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
        } else {
            $arr = ['password' => Hash::make($request->password)];
            $update = User::where('id', $id)->update($arr);
            if ($update) {
                return redirect()->back()->with('success', 'Password Updated!');
            }
        }
    }

    public function logout()
    {
        Auth::guard('seller')->logout();
        return ['status' => 1, 'message' => 'successfully logout!'];
    }

    public function setQuestion(Request $request)
    {
        $seller_id = $request->seller_id;
        $question_id = $request->question_id;
        $answer = $request->answer;
        $relation = UserQuestionRelation::where('seller_id', $seller_id)->first();
        if ($relation) {
            $relation->answer = $answer;
            $relation->question_id = $question_id;
            $relation->save();
        } else {
            UserQuestionRelation::create($request->all());
        }
        return ['status' => 1, 'message' => 'succefully created!'];
    }

    public function getQuestionsByEmail(Request $request)
    {
        $seller = Seller::where('email', $request->email)->first();
        return $seller->questions->first();
    }

    public function checkQuestion(Request $request)
    {
        $seller = Seller::where('email', $request->email)->first();
        $relation = UserQuestionRelation::where('seller_id', $seller->id)->first();
        if ($relation->answer == $request->answer) {
            return [
                'status' => 1,
                'message' => 'Answer is correct',
            ];
        } else {
            return [
                'status' => 0,
                'message' => 'Answer is wrong',
            ];
        }
    }

    public function resetPasswordV1(Request $request)
    {
        $arr = ['password' => Hash::make($request->password)];
        $update = Seller::where('email', $request->email)->update($arr);
        return [
            'status' => 1,
            'message' => 'Password Updated Correctly',
        ];
    }

}
