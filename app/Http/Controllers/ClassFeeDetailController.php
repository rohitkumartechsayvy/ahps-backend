<?php

namespace App\Http\Controllers;

use App\Models\ClassFeeDetail;
use Illuminate\Http\Request;

class ClassFeeDetailController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function fetchMonthlyFee($id)
  {
    $monthly_fee_details = ClassFeeDetail::where('class_id', $id)->get();
    return apiResponse(200, lang('Months Fetched successfully!'), null, $monthly_fee_details);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function updateFee(Request $request)
  {
    $inputs =  $request->all();
    $validator = ClassFeeDetail::validateFeeDetails($inputs);
    if ($validator->fails()) {
      $messages = implode(",", errorMessages($validator->messages()));
      return apiResponse(200, $messages, null, null);
    }
    $existing_entry =  ClassFeeDetail::where('month_id', $inputs['month_id'])->where('class_id', $inputs['class_id'])->first();
    $details = null;
    if (isset($existing_entry)) {
      $details = ClassFeeDetail::where('month_id', $inputs['month_id'])->where('class_id', $inputs['class_id'])->update(['monthly_fee' => $inputs['monthly_fee']]);
    } else {
      $details = ClassFeeDetail::create($inputs);
    }
    return apiResponse(200, lang('Class Fee Updated successfully!'), null, null);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\ClassFeeDetail  $classFeeDetail
   * @return \Illuminate\Http\Response
   */
  public function show(ClassFeeDetail $classFeeDetail)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\ClassFeeDetail  $classFeeDetail
   * @return \Illuminate\Http\Response
   */
  public function edit(ClassFeeDetail $classFeeDetail)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\ClassFeeDetail  $classFeeDetail
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, ClassFeeDetail $classFeeDetail)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\ClassFeeDetail  $classFeeDetail
   * @return \Illuminate\Http\Response
   */
  public function destroy(ClassFeeDetail $classFeeDetail)
  {
    //
  }
}
