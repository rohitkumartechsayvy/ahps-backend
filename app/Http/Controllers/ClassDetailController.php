<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\ClassDetail;
use App\Models\ClassIncharge;
use App\Models\ClassSubject;
use Illuminate\Http\Request;
use DB;
use App\Models\Exam;
use App\Models\ReportCard;
use App\Models\TimeTable;
use App\Models\Subject;
use App\User;

class ClassDetailController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function fetchClass($id)
  {
    $class_details = ClassDetail::fetchClass($id);
    $class_details->incharge = (ClassIncharge::where('class_id', $id)->value('teacher_id')) ? ClassIncharge::where('class_id', $id)->value('teacher_id') : null;
    $class_details->subjects = ClassSubject::getSubjects($id);
    $class_details->students = ClassDetail::getStudentByClass($id);
    $class_details->attendance_marked = Attendance::AttendanceMarked($id);
    $hours = DB::table('hours')->get();
    $days = DB::table('days')->get();
    $new_timetable = [];

    if (isset($days) && count($days) > 0) {
      foreach ($days as $day_key => $day_value) {
        $obj['day'] = $day_value->day;
        $obj['timeTableList'] = [];
        if (isset($hours) && count($hours) > 0) {
          $ob = [];
          foreach ($hours as $key => $value) {
            $timetable = TimeTable::where('day_id', $day_value->id)->where('hour_id', $value->id)->where('class_id', $id)->first();
            if ($timetable) {
              array_push($ob, [
                'time_table_id' => $timetable->id,
                'teacher_id' => $timetable->teacher_id,
                'class_id' => $timetable->class_id,
                'subject_id' => $timetable->subject_id,
                'day' => $day_value->day,
                'hour' => $value->from . '-' . $value->to,
                'class_name'   => ClassDetail::where('id', $timetable->class_id)->value('class_name'),
                'teacher_name' => User::where('id', $timetable->teacher_id)->value('name'),
                'subject_name' => Subject::where('id', $timetable->subject_id)->value('subject_name')
              ]);
            }
          }
        }
        if (isset($ob) && count($ob) > 0) {
          $obj['timeTableList'] = $ob;
        }
        $new_timetable[] = $obj;
      }
    }
    $class_details->timetable = $new_timetable;
    if (isset($class_details)) {
      return apiResponse(200, lang('Class Data fetched successfully!'), null, $class_details);
    } else {
      return apiResponse(200, lang('No Class Data FOund!'), null, null);
    }
  }

  public function getAssignedClasses($id)
  {
    $class_details = ClassDetail::getAssignedClasses($id);
    if (isset($class_details)) {
      return apiResponse(200, lang('Class Data fetched successfully!'), null, $class_details);
    } else {
      return apiResponse(200, lang('No Class Data FOund!'), null, null);
    }
  }
  public function getSubjectClasses($id)
  {
    $class_details = ClassDetail::getSubjectClasses($id);
    $classes = array_keys($class_details->toArray());
    $classes_details = ClassDetail::whereIn('id', $classes)->get();
    if (isset($classes_details)) {
      return apiResponse(200, lang('Class Data fetched successfully!'), null, $classes_details);
    } else {
      return apiResponse(200, lang('No Class Data FOund!'), null, null);
    }
  }

  public function getStudentByClass($class_id)
  {
    $class_students = ClassDetail::getStudentByClass($class_id);
    if (isset($class_students)) {
      foreach ($class_students as $key => $stu) {
        $active_exam = Exam::where('exam_status', 'active')->value('id');
        $check_report = ReportCard::where('exam_id', $active_exam)->where('student_id', $stu->id)->first();
        if (isset($check_report)) {
          $class_students[$key]->report_genrated = 1;
        } else {
          $class_students[$key]->report_genrated = 0;
        }
        $student_details = User::fetchStudent($stu->id);
        if (isset($student_details)) {
          $class_students[$key]->dob = $student_details->dob ? $student_details->dob : '-';
          $class_students[$key]->father_name = $student_details->father_name ? $student_details->father_name : '-';
          $class_students[$key]->mother_name = $student_details->mother_name ? $student_details->mother_name : '-';
          $class_students[$key]->nationality = $student_details->nationality ? $student_details->nationality : '-';
          $class_students[$key]->religion = $student_details->religion ? $student_details->religion : '-';
          $class_students[$key]->category = $student_details->category ? $student_details->category : '-';
          $class_students[$key]->adhaar_card = $student_details->adhaar_card ? $student_details->adhaar_card : '-';
          $class_students[$key]->gender = $student_details->gender ? $student_details->gender : '-';
          $class_students[$key]->admission_no = $student_details->admission_no ? $student_details->admission_no : '-';
          $class_students[$key]->roll_no = $student_details->roll_no ? $student_details->roll_no : '-';
          $class_students[$key]->joining_date = $student_details->joining_date ? $student_details->joining_date : '-';
          $class_students[$key]->guardian = $student_details->guardian ? $student_details->guardian : '-';
          $class_students[$key]->relation = $student_details->relation ? $student_details->relation : '-';
          $class_students[$key]->occupation = $student_details->occupation ? $student_details->occupation : '-';
          $class_students[$key]->last_school = $student_details->last_school ? $student_details->last_school : '-';
          $class_students[$key]->transfer_certificate = $student_details->transfer_certificate ? $student_details->transfer_certificate : '-';
          $class_students[$key]->migration_certificate = $student_details->migration_certificate ? $student_details->migration_certificate : '-';
          $class_students[$key]->birth_certificate = $student_details->birth_certificate ? $student_details->birth_certificate : '-';
          $class_students[$key]->marksheet_certificate = $student_details->marksheet_certificate ? $student_details->marksheet_certificate : '-';
          $class_students[$key]->adhaar_card_certificate = $student_details->adhaar_card_certificate ? $student_details->adhaar_card_certificate : '-';
        }
      }
      return apiResponse(200, lang('Class Data fetched successfully!'), null, $class_students);
    } else {
      return apiResponse(200, lang('No Class Data FOund!'), null, null);
    }
  }

  public function updateClass(Request $request, $id)
  {
    $inputs = $request->all();
    $class_details = ClassDetail::where('id', $id)->update(['class_name' => $inputs['class_name']]);
    if (isset($inputs['class_incharge'])) {
      $get_entry = ClassIncharge::where('class_id', $id)->where('status', 1)->first();
      if (isset($get_entry)) {
        ClassIncharge::where('class_id', $id)->where('status', 1)->update(['status' => 2, 'changed_by' => $inputs['changed_by'], 'to' => date('Y-m-d h:i:s')]);
        $incharge['teacher_id'] = $inputs['class_incharge'];
        $incharge['class_id'] = $id;
        $incharge['from'] = date('Y-m-d h:i:s');
        $incharge['status'] = 1;
        $incharge['changed_by'] = $inputs['changed_by'];
        ClassIncharge::create($incharge);
      } else {
        $incharge['teacher_id'] = $inputs['class_incharge'];
        $incharge['class_id'] = $id;
        $incharge['from'] = date('Y-m-d h:i:s');
        $incharge['status'] = 1;
        $incharge['changed_by'] = $inputs['changed_by'];
        ClassIncharge::create($incharge);
      }
    }
    if (isset($inputs['subjects']) && count($inputs['subjects']) > 0) {
      ClassSubject::where('class_id', $id)->delete();
      foreach ($inputs['subjects'] as $key => $item) {
        $sub['class_id'] = null;
        $sub['subject_id'] = null;
        $sub['class_id'] = $id;
        $sub['subject_id'] = $item['value'];
        ClassSubject::create($sub);
      }
    }
    return apiResponse(200, lang('Class Updated Successfully!'), null, $class_details);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function getClasses()
  {
    $data = [];
    $classes = ClassDetail::get();
    if (isset($classes) && count($classes) > 0) {
      foreach ($classes as $key => $class) {
        $classes[$key]['subjects'] = DB::table('class_subjects')->select('subjects.subject_name as subject_name')->join('subjects', 'subjects.id', 'class_subjects.subject_id')->where('class_subjects.class_id', $class->id)->get();
        $incharge_details = DB::table('class_incharges')->select('users.name as incharge_name', 'class_incharges.teacher_id as incharge_id')->join('users', 'users.id', 'class_incharges.teacher_id')->where('class_incharges.class_id', $class->id)->first();
        $classes[$key]['class_incharge'] = $incharge_details ? $incharge_details->incharge_name : '';
        $classes[$key]['incharge_id'] = $incharge_details ? $incharge_details->incharge_id : '';
      }
      $data = $classes;
    }
    return apiResponse(200, lang('Classes Fetched Successfully!'), null, $data);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function createClass(Request $request)
  {
    $inputs = $request->all();
    $validator = ClassDetail::validateClass($inputs);
    if ($validator->fails()) {
      $messages = implode(",", errorMessages($validator->messages()));
      return apiResponse(200, $messages, null, null);
    }
    $class_details = ClassDetail::create($inputs);
    if (isset($class_details)) {
      if (isset($inputs['class_incharge'])) {
        $incharge['teacher_id'] = $inputs['class_incharge'];
        $incharge['class_id'] = $class_details->id;
        $incharge['from'] = date('Y-m-d h:i:s');
        $incharge['status'] = 1;
        $incharge['changed_by'] = $inputs['changed_by'];
        ClassIncharge::create($incharge);
      }
      if (isset($inputs['subjects']) && count($inputs['subjects']) > 0) {
        foreach ($inputs['subjects'] as $key => $item) {
          $sub['class_id'] = null;
          $sub['subject_id'] = null;
          $sub['class_id'] = $class_details->id;
          $sub['subject_id'] = $item['value'];
          ClassSubject::create($sub);
        }
      }
      return apiResponse(200, lang('Class Created successfully!'), null, $class_details);
    } else {
      return apiResponse(200, lang('Something Went Wrong!'), null, null);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\ClassDetail  $classDetail
   * @return \Illuminate\Http\Response
   */
  public function show(ClassDetail $classDetail)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\ClassDetail  $classDetail
   * @return \Illuminate\Http\Response
   */
  public function edit(ClassDetail $classDetail)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\ClassDetail  $classDetail
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, ClassDetail $classDetail)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\ClassDetail  $classDetail
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request, $id)
  {
    ClassDetail::where('id', $id)->delete();
    return apiResponse(200, lang('Class deleted successfully!'), null, null);
  }
}
