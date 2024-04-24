<?php

namespace App\Http\Controllers;

use App\Models\ClassDetail;
use App\Models\FeeDetail;
use App\Models\FeeLog;
use Illuminate\Http\Request;
use DB;

class FeeDetailController extends Controller
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
  public function createCharges(Request $request)
  {
    try {
      $feeDetail['title'] = $request->title;
      $fee_details = FeeDetail::create($feeDetail);
      if (isset($request->fee_charges) && count($request->fee_charges) > 0) {
        foreach ($request->fee_charges as $key => $value) {
          $obj = [];
          $obj['class_id'] = $key;
          $obj['amount'] = $value;
          $obj['fee_id'] = $fee_details->id;
          FeeLog::create($obj);
        }
      }
      return apiResponse(200, lang('Charges Created successfully!'), null, null);
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function getCharges()
  {
    $records = FeeDetail::get();
    $response = [];
    if (isset($records) && count($records) > 0) {
      foreach ($records as $key => $value) {
        $data['fee_details'] =  FeeDetail::where('id', $value->id)->first();
        $data['fee_charges'] = [];
        $fee_logs = FeeLog::where('fee_id', $value->id)->get();
        if (isset($fee_logs) && count($fee_logs) > 0) {
          foreach ($fee_logs as $key2 => $value2) {
            $class_details = ClassDetail::where('id', $value2->class_id)->first();
            if (isset($class_details)) {
              $obj = [];
              $obj['charge_title'] = $value->title;
              $obj['class_name'] = $class_details->class_name;
              $obj['monthly_fee'] =  $value2['amount'];
              $data['fee_charges'][] = $obj;
            }
          }
        }
        $response[] = $data;
      }
    }
    return apiResponse(200, lang('Charges Details Fetched successfully!'), null, $response);
  }
  public function getOnlyCharges()
  {
    $response = FeeDetail::get();
    return apiResponse(200, lang('Charges Details Fetched successfully!'), null, $response);
  }
  /**
   * Display the specified resource.
   *
   * @param  \App\Models\FeeDetail  $feeDetail
   * @return \Illuminate\Http\Response
   */
  public function fetchCharge($id)
  {
    $data['fee_details'] =  FeeDetail::where('id', $id)->first();
    if (isset($data['fee_details'])) {
      $data['fee_charges'] = [];
      $fee_logs = FeeLog::where('fee_id', $id)->get();
      if (isset($fee_logs) && count($fee_logs) > 0) {
        foreach ($fee_logs as $key2 => $value2) {
          $class_details = ClassDetail::where('id', $value2->class_id)->first();
          $obj = [];
          if (isset($class_details)) {
            $obj['class_id'] = $class_details->id;
            $obj['charge_title'] = $data['fee_details']->title;
            $obj['class_name'] = $class_details->class_name;
            $obj['monthly_fee'] =  $value2->amount;
            $data['fee_charges'][] = $obj;
          } else {
            return apiResponse(200, lang('Class charges not created yet!'), null, null);
          }
        }
      }
      if (isset($data)) {
        return apiResponse(200, lang('Charge Data fetched successfully!'), null, $data);
      } else {
        return apiResponse(200, lang('No Charge Data FOund!'), null, null);
      }
    } else {
      return apiResponse(200, lang('No Charge Data FOund!'), null, null);
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\FeeDetail  $feeDetail
   * @return \Illuminate\Http\Response
   */
  public function edit(FeeDetail $feeDetail)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\FeeDetail  $feeDetail
   * @return \Illuminate\Http\Response
   */
  public function updateCharge(Request $request, $id)
  {
    try {
      $feeDetail['title'] = $request->title;
      $fee_details = FeeDetail::where('id', $id)->update(['title' => $request->title]);
      if (isset($request->fee_charges) && count($request->fee_charges) > 0) {
        foreach ($request->fee_charges as $key => $value) {
          $get_old_record = FeeLog::where('id', $id)->where('class_id', $key)->first();
          if (isset($get_old_record)) {
            FeeLog::where('id', $id)->where('class_id', $key)->update(['amount' => $value]);
          } else {
            $obj = [];
            $obj['class_id'] = $key;
            $obj['amount'] = $value;
            $obj['fee_id'] = $id;
            FeeLog::create($obj);
          }
        }
      }
      return apiResponse(200, lang('Charges Updated successfully!'), null, null);
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\FeeDetail  $feeDetail
   * @return \Illuminate\Http\Response
   */
  public function deleteCharge($id)
  {
    FeeDetail::where('id', $id)->delete();
    FeeLog::where('fee_id', $id)->delete();
    return apiResponse(200, lang('Charges Information deleted successfully!'), null, null);
  }
}
