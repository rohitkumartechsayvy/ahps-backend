<?php

namespace App\Http\Controllers;

use App\Models\ReportCard;
use App\Models\ReportCardLog;
use Illuminate\Http\Request;
use DB;
use App\Models\Subject;
use App\Models\ExamLog;
use App\User;
use App\Models\Exam;
use App\Models\ClassDetail;

class ReportCardController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function generateReportCard(Request $request)
  {
    if (isset($request->examData) && count($request->examData) > 0) {
      $exam_obj['exam_id'] = $request->examData['exam_id'];
      $exam_obj['student_id'] = $request->examData['student_id'];
      $exam_obj['grade_pointer'] = $request->examData['grade_pointer'] ? $request->examData['grade_pointer'] : '';
      $exam_obj['obtained_marks'] = $request->examData['obtained_marks'];
      $exam_obj['obtained_grade'] = $request->examData['obtained_grade']['value'];
      $exam_obj['obtained_position'] = $request->examData['obtained_position'];
      $exam_obj['class_id'] = $request->examData['class_id'];
      $card_details = ReportCard::create($exam_obj);
    }
    if (isset($card_details)) {
      if (isset($request->subjectData) && count($request->subjectData) > 0) {
        foreach ($request->subjectData as $key => $value) {
          $card_obj = [];
          $card_obj['report_card_id'] = $card_details->id;
          $card_obj['subject_id'] = $value['subject_id'];
          $card_obj['obtained_marks'] = $value['obtained_marks'];
          $card_obj['obtained_grade'] = $value['obtained_grade']['value'];
          $card_obj['obtained_position'] = $value['obtained_position'];
          ReportCardLog::create($card_obj);
        }
      }
    }
    return apiResponse(200, lang('Report Card Genrated Successfully!'), null, null);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function ReportCard($exam_id, $id)
  {

    $fetch_exams = ReportCard::where('student_id', $id)->where('exam_id', $exam_id)->first();
    if (isset($fetch_exams)) {
      $exam_logs = ReportCardLog::where('report_card_id', $fetch_exams->id)->get();
      $class_id = DB::table('student_school_statuses')->where('student_id', $id)->where('status', 'active')->value('class_id');
      $logs = [];
      $total_marks = 0;
      if (isset($exam_logs) && count($exam_logs) > 0) {
        foreach ($exam_logs as $key => $log) {
          $report_log = [];
          $exam_log = ExamLog::where('class_id', $class_id)->where('subject_id', $log->subject_id)->first();
          // dd($exam_log);
          $total_marks += $exam_log->max_marks ? (int) $exam_log->max_marks : 0;
          $report_log['subject'] = Subject::where('id', $log->subject_id)->value('subject_name');
          $report_log['subject_max_marks'] = $exam_log->max_marks ? $exam_log->max_marks : 0;
          $report_log['subject_obtained_marks'] =  $log->obtained_marks;
          $report_log['subject_max_grade'] = $exam_log->max_grade;
          $report_log['subject_obtained_grade'] = $log->obtained_grade;
          $report_log['subject_passing_marks'] = $exam_log->passing_marks;;
          $report_log['subject_passing_grade'] = $exam_log->passing_grade;
          $report_log['subject_obtained_position'] = $log->obtained_position;
          $logs[] = $report_log;
        }
      }
      $fetch_exams->logs = $logs;
      $fetch_exams->student_details = User::fetchStudent($id);
      $fetch_exams->exam_details = Exam::where('id', $exam_id)->first();
      unset(($fetch_exams->student_details)->password);
      $fetch_exams->class_name = ClassDetail::where('id', $class_id)->value('class_name');
      $fetch_exams->total_marks = $total_marks;
      return apiResponse(200, lang("Report Card Fetched Successfully!"), null, $fetch_exams);
    } else {
      return apiResponse(200, lang("No Report Card Generated Yet!"), null, null);
    }
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
   * @param  \App\Models\ReportCard  $reportCard
   * @return \Illuminate\Http\Response
   */
  public function show(ReportCard $reportCard)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\ReportCard  $reportCard
   * @return \Illuminate\Http\Response
   */
  public function edit(ReportCard $reportCard)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\ReportCard  $reportCard
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, ReportCard $reportCard)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\ReportCard  $reportCard
   * @return \Illuminate\Http\Response
   */
  public function destroy(ReportCard $reportCard)
  {
    //
  }
}
