<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Mail\Register;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
  // USER REGISTER
  public function register(Request $request)
  {
    $inputs = $request->all();
    $validator = User::validateUser($inputs);
    if ($validator->fails()) {
      $messages = implode(",", errorMessages($validator->messages()));
      return json_encode(array("statusCode" => 400, "message" => $messages));
    }
    $inputs['password'] = Hash::make($request->post('password'));
    $inputs['user_type'] = config('resell.auth.user_type');
    $user_details = User::create($inputs);
    $user_name = $user_details->first_name . ' ' . $user_details->last_name;
    Mail::to($user_details->email)->send(new Register($user_name));
    $response['user_id'] = $user_details->id;
    $response['first_name'] = $user_details->first_name;
    $response['last_name'] = $user_details->last_name;
    $response['company_name'] = $user_details->company_name;
    $response['email'] = $user_details->email;
    if (isset($response)) {
      return apiResponse(200, lang('User Registered successfully'), null, $response);
    } else {
      return apiResponse(400, lang('Something Went Wrong!'), null, null);
    }
  }
  // USER REGISTER
}
