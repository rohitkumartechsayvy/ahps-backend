<?php

namespace App\Http\Controllers;

use App\Models\ExamLog;
use Illuminate\Http\Request;

class ExamLogController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function saveExamLog(Request $request)
  {
    $inputs = $request->all();
    foreach ($inputs as $key => $value) {
      $get_record = ExamLog::where('subject_id', $value['subject_id'])->where('class_id', $value['class_id'])->first();
      if (isset($get_record)) {
        ExamLog::where('id', $get_record->id)->update(['max_marks' => $value['max_marks'], 'passing_marks' => $value['passing_marks'], 'max_grade' => $value['max_grade']['value'], 'passing_grade' => $value['passing_grade']['value']]);
      } else {
        $exam_log['subject_id'] = $value['subject_id'];
        $exam_log['class_id'] = $value['class_id'];
        $exam_log['max_marks'] = $value['max_marks'];
        $exam_log['passing_marks'] = $value['passing_marks'];
        $exam_log['max_grade'] = $value['max_grade']['value'];
        $exam_log['passing_grade'] = $value['passing_grade']['value'];
        ExamLog::create($exam_log);
      }
    }
    return apiResponse(200, lang('Subject Marks Updated Successfully!'), null, null);
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
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\ExamLog  $examLog
   * @return \Illuminate\Http\Response
   */
  public function show(ExamLog $examLog)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\ExamLog  $examLog
   * @return \Illuminate\Http\Response
   */
  public function edit(ExamLog $examLog)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\ExamLog  $examLog
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, ExamLog $examLog)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\ExamLog  $examLog
   * @return \Illuminate\Http\Response
   */
  public function destroy(ExamLog $examLog)
  {
    //
  }
}
