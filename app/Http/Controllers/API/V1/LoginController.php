<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Exception;
use App\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\Providers\JWT;

class LoginController extends Controller
{
  /**
   * With the request-> only method, we only take the email-password as a *parameter and perform the user authentication with the attempt *function of the auth method in the laravel. If the user is correct, we *return a token for the user to use for later processing.
   *
   * @param Request $request
   * @return JsonResponse
   */
  // USER LOGIN
  public function login(Request $request)
  {
    $response = [];
    // dd($request->all());
    $credentials = $request->only(['email', 'password']);
    try {
      if (!$token = JWTAuth::attempt($credentials)) {
        return apiResponse(400, lang('Invalid Credentials'), null, null);
      }
      $logged_in = User::where('email', $request->email)->where('user_type', (int) $request->user_type)->first();
      if (isset($logged_in)) {
        $token = JWTAuth::fromUser($logged_in);
      } else {
        return apiResponse(400, lang('Invalid Credentials'), null, null);
      }
    } catch (Exception $e) {
      return apiResponse(401, lang($e->getMessage()), null, null);
    } catch (JWTException $e) {
      return apiResponse(500, lang('Could not create token!'), null, null);
    }
    $user_details = User::validateLogin($request->all());
    if ($user_details->status == 'inactive' || $user_details->is_blocked == 'blocked') {
      return apiResponse(200, lang('User Status is not Active!'), null, $response);
    }
    $response['id'] = $user_details->id;
    $response['name'] = $user_details->name;
    $response['user_type'] = $user_details->user_type;
    $response['status'] = $user_details->status;
    $response['profile_picture'] = url($user_details->profile_picture);
    $response['email'] = $user_details->email;
    $response['_token'] = $token;
    return apiResponse(200, lang('User Logged in Successfully!'), null, $response);
  }
  // USER LOGIN

  // FORGOT PASSWORD
  public function forgotPassword(Request $request)
  {
    $inputs = $request->all();
    $rules = [
      'email' => 'required|email'
    ];
    $validator = Validator::make($inputs, $rules);
    if ($validator->fails()) {
      $messages = implode(",", errorMessages($validator->messages()));
      return json_encode(array("statusCode" => 400, "message" => $messages));
    }
    $user_details = User::validateLogin($inputs);
    if (isset($user_details)) {
      $insert['email'] = $user_details->email;
      $insert['token'] = mt_rand(100000, 999999);
      $insert['created_at'] = Carbon::now();
      $fetch = DB::table('password_resets')->insert($insert);
      if ($fetch) {
        $data['url'] = $insert['token'];
        $view = view('emails.dummy', compact('data'));
        $final = $view->render();
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom(fromEmail(), "Achiever's Hub");
        $email->setSubject(config('app.name') . " Forgot Password");
        $email->addTo($user_details->email);
        $email->addBcc(fromEmail());
        $email->addContent("text/html", $final);
       // $sendgrid = new \SendGrid('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');
        try {
          $response = $sendgrid->send($email);
        } catch (Exception $e) {
          echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
      }
      // dd($fetch);
      return apiResponse(200, lang('A mail has been sent to your email address with OTP. Please check to set new password'), null, []);
    } else {
      return apiResponse(200, lang('Email Id Does not exist!'), null, null);
    }
  }
  // FORGOT PASSWORD
  public function resetPasswordConfirm(Request $request)
  {
    $token = $request->token;
    $user_id = DB::table('password_resets')->where('token', $token)->where('email', $request->email)->first();
    if (isset($user_id)) {
      if ((Carbon::parse($user_id->created_at))->addMinutes(200) < now()) {
        return apiResponse(200, lang('Token has been expired!'), null, null);
      } else {
        return apiResponse(200, lang('Please update new password!'), null, $user_id);
      }
    } else {
      return apiResponse(200, lang('Invalid token Or Email!'), null, null);
    }
  }

  public function setPassword(Request $request)
  {
    $user = User::where('email', $request->email)->first();
    if ($user) {
      if (Hash::check($request->old_password, $user->password)) {
        if (Hash::check($request->password, $user->password)) {
          return apiResponse(200, null, ['New Password should not match the old one!'], null);
        } else {
          $new_data['password'] = Hash::make($request->password);
          $resp = User::where('id', $user->id)->update($new_data);
          if ($resp) {
            return apiResponse(200, lang('Password Updated Successfully!'), null, []);
          } else {
            return apiResponse(200, null, ['Something went wrong!'], null);
          }
        }
      } else {
        return apiResponse(400, lang('Old Password does not match!'), null, null);
      }
    } else {
      return apiResponse(200, lang('User Does Not Exist!'), null, null);
    }
  }
  public function updatePassword(Request $request)
  {
    $user = User::where('email', $request->email)->first();
    if ($user) {
      $new_data['password'] = Hash::make($request->password);
      $resp = User::where('id', $user->id)->update($new_data);
      if ($resp) {
        return apiResponse(200, lang('Password Updated Successfully!'), null, []);
      } else {
        return apiResponse(200, null, ['Something went wrong!'], null);
      }
    } else {
      return apiResponse(200, lang('User Does Not Exist!'), null, null);
    }
  }

  // WEB LOGIN
  public function Weblogin(Request $request)
  {
    // dd($request->all());
    $response = [];
    $credentials = $request->only(['email', 'password']);
    try {
      if (!$token = JWTAuth::attempt($credentials)) {
        return apiResponse(200, lang('Invalid Credentials'), null, null);
      }
    } catch (Exception $e) {
      return apiResponse(401, lang($e->getMessage()), null, null);
    } catch (JWTException $e) {
      return apiResponse(500, lang('Could not create token!'), null, null);
    }
    $user_details = User::adminLogin($credentials);
    if (isset($user_details)) {
      $response['id'] = $user_details->id;
      $response['name'] = $user_details->name;
      $response['user_type'] = $user_details->user_type;
      $response['status'] = $user_details->status;
      $response['profile_picture'] = url($user_details->profile_picture);
      $response['email'] = $user_details->email;
      $response['_token'] = $token;
      return apiResponse(200, lang('User Logged in Successfully!'), null, $response);
    } else {
      return apiResponse(200, lang('Invalid Credentials'), null, null);
    }
  }
  // WEB LOGIN
}
