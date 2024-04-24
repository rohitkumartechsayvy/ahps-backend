<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Mail\Testmail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function contact(Request $request)
  {
    // dd($request->all());
    $inputs = $request->all();
    // dd($inputs);
    $validator = Contact::validateInputs($inputs);

    if ($validator->fails()) {
      $messages = implode(",", errorMessages($validator->messages()));
      return json_encode(array("statusCode" => 400, "message" => $messages));
    }
    Contact::create($inputs);
    // return json_encode(array("statusCode" => 200, "message" => 'Contact Query Sent Successfully!'));
    return apiResponse(200, lang('Contact Query Sent Successfully!'), null, null);
  }

  public function mail()
  {
    $data['url'] = 'google.com';
    $view = view('emails.dummy', compact('data'));
    $final = $view->render();
    $subject = " Forgot Password";
    $to = 'anju.sharma045@gmail.com';
    // print_r($to);
    // print_r($subject);
    // print_r($final);
    // die;
    sendMail($to, $subject, $final);

    // Mail::to('anju.sharma045@gmail.com')->send(new Testmail());
  }
  public function contactQueries()
  {
    $queries = Contact::get();
    if (isset($queries) && count($queries) > 0) {
      return apiResponse(200, lang('Queries Fetched Successfully!'), null, $queries);
    } else {
      return apiResponse(200, lang('No Queries Found!'), null, null);
    }
  }
  public function fetchQuery($query_id)
  {
    $query_details = Contact::where('id', $query_id)->first();
    if (isset($query_details)) {
      return apiResponse(200, lang('Queries Information Fetched Successfully!'), null, $query_details);
    } else {
      return apiResponse(200, lang('No Queries Found!'), null, null);
    }
  }
}
