<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use DB;
use App\Models\Exam;
use App\Models\ExamLog;
use App\Models\StudentSchoolStatus;
use App\Models\TimeTable;

class SubjectController extends Controller
{
  public function fetchSubject($id)
  {
    $subject_details = Subject::fetchSubject($id);
    if (isset($subject_details)) {
      return apiResponse(200, lang('Subject Data fetched successfully!'), null, $subject_details);
    } else {
      return apiResponse(200, lang('No Subject Data FOund!'), null, null);
    }
  }

  public function updateSubject(Request $request, $id)
  {
    $inputs = $request->all();
    $validator = Subject::validateEditSubject($inputs, $id);
    if ($validator->fails()) {
      $messages = implode(",", errorMessages($validator->messages()));
      return apiResponse(200, null, [$messages], null);
    }
    $subject_details = Subject::where('id', $id)->update(['subject_name' => $inputs['subject_name']]);
    return apiResponse(200, lang('Subject Updated Successfully!'), null, $subject_details);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function getSubjects()
  {
    $data = [];
    $subjects = Subject::get();
    if (isset($subjects) && count($subjects) > 0) {
      $data = $subjects;
    }
    return apiResponse(200, lang('Subjects Fetched Successfully!'), null, $data);
  }

  public function getClassSubjects($id)
  {
    $subjectData = [];
    $subjects = DB::table('subjects')->select('*', 'subjects.id as id')->join('class_subjects', 'class_subjects.subject_id', 'subjects.id')->where('class_subjects.class_id', $id)->get();
    if (isset($subjects) && count($subjects) > 0) {
      foreach ($subjects as $key => $subject) {
        $get_record = ExamLog::where('subject_id', $subject->id)->where('class_id', $id)->first();
        $obj = [];
        $obj['subject_id'] = $subject->id;
        $obj['subject_name'] = $subject->subject_name;
        $obj['class_id'] = $id;
        $obj['max_marks'] = ($get_record && $get_record->max_marks) ? $get_record->max_marks : null;
        $obj['passing_marks'] = ($get_record && $get_record->passing_marks) ? $get_record->passing_marks : null;
        $obj['max_grade']['value'] = ($get_record && $get_record->max_grade) ? $get_record->max_grade : null;
        $obj['max_grade']['label'] = ($get_record && $get_record->max_grade) ? $get_record->max_grade : null;
        $obj['passing_grade']['value'] = ($get_record && $get_record->passing_grade) ? $get_record->passing_grade : null;
        $obj['passing_grade']['label'] = ($get_record && $get_record->passing_grade) ? $get_record->passing_grade : null;
        $subjectData[] = $obj;
      }
    }
    return apiResponse(200, lang('Subjects Fetched Successfully!'), null, $subjectData);
  }
  public function getTeacherSubjects(Request $request)
  {
    $subjects = TimeTable::where('teacher_id', $request->userId)->where('class_id', $request->classId)->get()->groupBy('subject_id');
    $subjectData = [];
    if (isset($subjects) && count($subjects) > 0) {
      foreach ($subjects as $key => $subject) {
        $obj = [];
        $obj['subject_id'] = $key;
        $obj['subject_name'] = Subject::where('id', $key)->value('subject_name');
        $obj['class_id'] = $request->classId;
        $subjectData[] = $obj;
      }
    }
    return apiResponse(200, lang('Subjects Fetched Successfully!'), null, $subjectData);
  }
  public function fetchStudentReport($id)
  {
    $class_id = StudentSchoolStatus::where('student_id', $id)->where('status', 'active')->value('class_id');
    $data['subjectData'] = [];
    $full_marks = 0;
    $subjects = DB::table('subjects')->select('*', 'subjects.id as id')->join('class_subjects', 'class_subjects.subject_id', 'subjects.id')->where('class_subjects.class_id', $class_id)->get();
    if (isset($subjects) && count($subjects) > 0) {
      foreach ($subjects as $key => $subject) {
        $get_record = ExamLog::where('subject_id', $subject->id)->where('class_id', $class_id)->first();
        $full_marks  += (int) (($get_record && $get_record->max_marks) ? $get_record->max_marks : 0);
        $obj = [];
        $obj['subject_id'] = $subject->id;
        $obj['subject_name'] = $subject->subject_name;
        $obj['class_id'] = $class_id;
        $obj['max_marks'] = ($get_record && $get_record->max_marks) ? $get_record->max_marks : null;
        $obj['obtained_marks'] = null;
        $obj['max_grade']['value'] = ($get_record && $get_record->max_grade) ? $get_record->max_grade : null;
        $obj['max_grade']['label'] = ($get_record && $get_record->max_grade) ? $get_record->max_grade : null;
        $obj['obtained_grade']['value'] = null;
        $obj['obtained_grade']['label'] = null;
        $obj['obtained_position'] = null;
        $data['subjectData'][] = $obj;
      }
    }
    $data['examData']['student_id'] = $id;
    $data['examData']['class_id'] = $class_id;
    $data['examData']['max_grade']['value'] = 1;
    $data['examData']['max_grade']['label'] = 'A+';
    $data['examData']['max_marks'] = $full_marks;
    $data['examData']['grade_pointer'] = null;
    $data['examData']['obtained_marks'] = null;
    $data['examData']['obtained_grade']['value'] = null;
    $data['examData']['obtained_grade']['label'] = null;
    $data['examData']['obtained_position'] = null;
    $data['examData']['exam_id'] = Exam::where('exam_status', 'active')->value('id');
    return apiResponse(200, lang('Subjects Fetched Successfully!'), null, $data);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function createSubject(Request $request)
  {
    $inputs = $request->all();
    $validator = Subject::validateSubject($inputs);
    if ($validator->fails()) {
      $messages = implode(",", errorMessages($validator->messages()));
      return apiResponse(200, $messages, null, null);
    }
    $subject_details = Subject::create($inputs);
    return apiResponse(200, lang('Subject Created successfully!'), null, $subject_details);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Subject  $Subject
   * @return \Illuminate\Http\Response
   */
  public function show(Subject $Subject)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Subject  $Subject
   * @return \Illuminate\Http\Response
   */
  public function edit(Subject $Subject)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Subject  $Subject
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Subject $Subject)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Subject  $Subject
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request, $id)
  {
    Subject::where('id', $id)->delete();
    return apiResponse(200, lang('Subject deleted successfully!'), null, null);
  }
}
