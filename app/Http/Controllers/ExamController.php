<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
  public function createExam(Request $request)
  {
    $inputs = $request->all();
    $exam_details = Exam::create($inputs);
    return apiResponse(200, lang('Exam Created successfully!'), null, $exam_details);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function getExams()
  {
    $data = [];
    $exams = Exam::get();
    if (isset($exams) && count($exams) > 0) {
      $data = $exams;
    }
    return apiResponse(200, lang('Exams Fetched Successfully!'), null, $data);
  }

  public function getActiveExams()
  {
    $data = [];
    $exams = Exam::where('exam_status', 1)->get();
    if (isset($exams) && count($exams) > 0) {
      $data = $exams;
    }
    return apiResponse(200, lang('Exams Fetched Successfully!'), null, $data);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Exam  $exam
   * @return \Illuminate\Http\Response
   */
  public function fetchExam($id)
  {
    $exam_details = Exam::where('id', $id)->first();
    if (isset($exam_details)) {
      return apiResponse(200, lang('Exam Data fetched successfully!'), null, $exam_details);
    } else {
      return apiResponse(200, lang('No Exam Data FOund!'), null, null);
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Exam  $exam
   * @return \Illuminate\Http\Response
   */
  public function edit(Exam $exam)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Exam  $exam
   * @return \Illuminate\Http\Response
   */
  public function updateExam(Request $request, $id)
  {
    $inputs = $request->all();
    $exam_details = Exam::where('id', $id)->update(['exam_title' => $inputs['exam_title'], 'exam_type' => $inputs['exam_type'], 'exam_status' => $inputs['exam_status'], 'exam_month' => $inputs['exam_month']]);
    return apiResponse(200, lang('Exam Updated Successfully!'), null, $exam_details);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Exam  $exam
   * @return \Illuminate\Http\Response
   */
  public function deleteExam($id)
  {
    $exam_details = Exam::where('id', $id)->delete();
    if (isset($exam_details)) {
      return apiResponse(200, lang('Exam Updated Successfully!'), null, $exam_details);
    } else {
      return apiResponse(400, lang('Something Went Wrong!'), null, null);
    }
  }
}
