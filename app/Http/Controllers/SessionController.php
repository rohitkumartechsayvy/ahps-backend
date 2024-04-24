<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function createSession(Request $request)
  {
    $inputs = $request->all();
    $validator = Session::validateSession($inputs);
    if ($validator->fails()) {
      $messages = implode(",", errorMessages($validator->messages()));
      return json_encode(array("statusCode" => 400, "message" => $messages));
    }
    $inputs['status'] = 1;
    $session_details = Session::create($inputs);
    return apiResponse(200, lang('Session Created successfully!'), null, $session_details);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function getSessions()
  {
    $data = [];
    $sessions = Session::get();
    if (isset($sessions) && count($sessions) > 0) {
      $data = $sessions;
    }
    return apiResponse(200, lang('Subjects Fetched Successfully!'), null, $data);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Session  $session
   * @return \Illuminate\Http\Response
   */
  public function fetchSession($id)
  {
    $session_details = Session::where('id', $id)->first();
    if (isset($session_details)) {
      return apiResponse(200, lang('Session Data fetched successfully!'), null, $session_details);
    } else {
      return apiResponse(200, lang('No Session Data FOund!'), null, null);
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Session  $session
   * @return \Illuminate\Http\Response
   */
  public function edit(Session $session)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Session  $session
   * @return \Illuminate\Http\Response
   */
  public function updateSession(Request $request, $id)
  {
    $inputs = $request->all();
    $session_details = Session::where('id', $id)->update(['from' => $inputs['from'], 'to' => $inputs['to'], 'session_status' => $inputs['session_status']]);
    return apiResponse(200, lang('Session Updated Successfully!'), null, $session_details);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Session  $session
   * @return \Illuminate\Http\Response
   */
  public function deleteSession($id)
  {
    $session_details = Session::where('id', $id)->delete();
    if (isset($session_details)) {
      return apiResponse(200, lang('Session Updated Successfully!'), null, $session_details);
    } else {
      return apiResponse(400, lang('Something Went Wrong!'), null, null);
    }
  }
}
