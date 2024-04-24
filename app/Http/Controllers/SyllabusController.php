<?php

namespace App\Http\Controllers;

use App\Models\ClassSubject;
use App\Models\Syllabus;
use Illuminate\Http\Request;
use DB;
use App\Models\Assignment;
use App\Models\ClassDetail;
use App\Models\TimeTable;
use App\Models\ClassIncharge;
use App\Models\Subject;
use App\Models\SubmittedAssignments;
use App\User;

class SyllabusController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function getClassSyllabus($id)
  {
    $subjectData = Syllabus::where('class_id', $id)->first();
    if (isset($subjectData->syllabus)) {
      $subjectData->syllabus = ($subjectData->syllabus) ? url($subjectData->syllabus) : null;
    }
    return apiResponse(200, lang('Syllabus Fetched Successfully!'), null, $subjectData);
  }
  public function getSyllabus()
  {
    $syllabuses = DB::table('syllabi')->join('class_details', 'syllabi.class_id', 'class_details.id')->get();
    if (isset($syllabuses) && count($syllabuses) > 0) {
      foreach ($syllabuses as $key => $syllabus) {
        $syllabuses[$key]->syllabus = $syllabuses[$key]->syllabus ?  url($syllabuses[$key]->syllabus) : "";
      }
    }
    // if (isset($subjectData->syllabus)) {
    //   $subjectData->syllabus = ($subjectData->syllabus) ? url($subjectData->syllabus) : null;
    // }
    return apiResponse(200, lang('Subjects Syllabus Fetched Successfully!'), null, $syllabuses);
  }
  public function getClassAssignments(Request $request, $id)
  {
    $records = Assignment::where('class_id', $id)->get();
    $assignmentData = [];
    if (isset($records) && count($records) > 0) {
      foreach ($records as $key2 => $record) {
        $record_obj = [];
        $record_obj['id'] = ($record && $record->id) ? $record->id : null;
        $record_obj['assignment'] = ($record && $record->assignment) ? url($record->assignment) : null;
        $record_obj['subject_id'] = ($record && $record->subject_id) ? $record->subject_id : null;
        $record_obj['subject_name'] = Subject::where('id', $record->subject_id)->value('subject_name');
        $record_obj['uploaded_by'] = User::where('id', $record->uploaded_by)->value('name');
        $record_obj['assignment_message'] = ($record && $record->assignment_message) ? $record->assignment_message : null;
        $assignmentData[] = $record_obj;
      }
    }
    return apiResponse(200, lang('Subject Assignments Fetched Successfully!'), null, $assignmentData);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function createSyllabus(Request $request)
  {
    $inputs = $request->all();
    if ($request->hasFile('syllabus')) {
      $file = $request->file('syllabus');
      $filename = $file->getClientOriginalName();
      $fileExtension = $file->getClientOriginalExtension();
      $name = 'profile_image_' . uniqid() . '.' . $file->getClientOriginalExtension();
      $request->syllabus->move(public_path() . '/storage/profile', $name);
      $path = 'storage/profile/' . $name;
      $inputs['syllabus'] = $path;
    } else {
      $inputs['syllabus'] = null;
    }
    $old_record = Syllabus::where('class_id', $request->class_id)->first();
    if (isset($old_record)) {
      $syllabus_details = Syllabus::where('class_id', $request->class_id)->update(['syllabus' => $inputs['syllabus']]);
    } else {
      $syllabus_details = Syllabus::create($inputs);
    }
    return apiResponse(200, lang('Syllabus Updated Successfully!'), null, null);
  }

  public function createAssignment(Request $request)
  {
    $inputs = $request->all();
    if ($request->hasFile('assignment')) {
      $filename = $request->file('assignment')->getClientOriginalName();
      $fileExtension = $request->file('assignment')->getClientOriginalExtension();
      $name = 'assignment_' . uniqid() . '.' . $request->file('assignment')->getClientOriginalExtension();
      $request->file('assignment')->move(public_path() . '/storage/assignments', $name);
      $assignments = 'storage/assignments/' . $name;
    }
    $obj['class_id'] = $inputs['class_id'];
    $obj['subject_id'] = $inputs['subject_id'];
    $obj['assignment_message'] = $inputs['assignment_message'];
    $obj['uploaded_by'] = $inputs['uploaded_by'];
    if (isset($assignments)) {
      $obj['assignment'] = $assignments;
    }
    $assignment_details = Assignment::create($obj);
    return apiResponse(200, lang('Assignment Updated Successfully!'), null, null);
  }

  public function uploadAssignment(Request $request)
  {
    $inputs = $request->all();
    $assignments = [];
    if ($request->hasFile('submitted_assignment')) {
      $filename = $request->file('submitted_assignment')->getClientOriginalName();
      $fileExtension = $request->file('submitted_assignment')->getClientOriginalExtension();
      $name = 'submitted_assignment_' . uniqid() . '.' . $request->file('submitted_assignment')->getClientOriginalExtension();
      $request->file('submitted_assignment')->move(public_path() . '/storage/assignments', $name);
      $assignments = 'storage/assignments/' . $name;
    }
    if (isset($assignments)) {
      $obj['submitted_assignment'] = $assignments;
      $obj['student_id'] = $inputs['student_id'];
      $obj['assignment_id'] = $inputs['assignment_id'];
      $assignment_details = SubmittedAssignments::create($obj);
    }
    return apiResponse(200, lang('Assignment Submitted Successfully!'), null, null);
  }
  public function uploadAadhar(Request $request)
  {
    $adhar_card = null;
    if ($request->hasFile('adhaar_card')) {
      $filename = $request->file('adhaar_card')->getClientOriginalName();
      $fileExtension = $request->file('adhaar_card')->getClientOriginalExtension();
      $name = 'adhaar_card_' . uniqid() . '.' . $request->file('adhaar_card')->getClientOriginalExtension();
      $request->file('adhaar_card')->move(public_path() . '/storage/assignments', $name);
      $adhar_card = 'storage/assignments/' . $name;
    }
    return apiResponse(200, lang('Aadhar Submitted Successfully!'), null, $adhar_card);
  }

  public function checkAssignment(Request $request)
  {
    $record = SubmittedAssignments::where('student_id', $request->student_id)->where('assignment_id', $request->assignment_id)->first();
    return apiResponse(200, lang('Assignment Fetched Successfully!'), null, $record);
  }
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function assignmentDetail($id)
  {
    $record = Assignment::where('id', $id)->first();
    $assignment_details['id'] = $id;
    $assignment_details['assignment'] = ($record && $record->assignment) ? url($record->assignment) : null;
    $assignment_details['subject_id'] = ($record && $record->subject_id) ? $record->subject_id : null;
    $assignment_details['subject_name'] = Subject::where('id', $record->subject_id)->value('subject_name');
    $assignment_details['uploaded_by'] = User::where('id', $record->uploaded_by)->value('name');
    $assignment_details['uploaded_on'] = ($record && $record->created_at) ? date('d M, Y', strtotime($record->created_at)) : null;
    $assignment_details['assignment_message'] = ($record && $record->assignment_message) ? $record->assignment_message : null;
    $assignment_details['pending_students'] = [];
    $assignment_details['submitted_students'] = [];
    $class_students = ClassDetail::getStudentByClass($record->class_id);
    // dd($class_students);
    if (isset($class_students)) {
      foreach ($class_students as $key => $stu) {
        $assignment_record = SubmittedAssignments::where('student_id', $stu->id)->where('assignment_id', $id)->first();
        $obj_stu['id'] = $stu->id;
        $obj_stu['name'] = $stu->name;
        if (isset($assignment_record)) {
          $obj_stu['submitted_assignment'] = url($assignment_record->submitted_assignment);
          $obj_stu['submitted_on'] = date('d M, Y', strtotime($assignment_record->created_at));
          $assignment_details['submitted_students'][] = $obj_stu;
        } else {
          $assignment_details['pending_students'][] = $obj_stu;
        }
      }
    }
    return apiResponse(200, lang('Assignment Fetched Successfully!'), null, $assignment_details);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Syllabus  $syllabus
   * @return \Illuminate\Http\Response
   */
  public function getStudentAssignments($id)
  {
    $class_id = DB::table('student_school_statuses')->where('student_id', $id)->where('status', 'active')->value('class_id');
    $records = Assignment::where('class_id', $class_id)->get();
    $assignmentData = [];
    if (isset($records) && count($records) > 0) {
      foreach ($records as $key2 => $record) {
        $assign_record = SubmittedAssignments::where('student_id', $id)->where('assignment_id', $record->id)->first();
        $record_obj = [];
        $record_obj['id'] = ($record && $record->id) ? $record->id : null;
        $record_obj['assignment'] = ($record && $record->assignment) ? url($record->assignment) : null;
        $record_obj['subject_id'] = ($record && $record->subject_id) ? $record->subject_id : null;
        $record_obj['subject_name'] = Subject::where('id', $record->subject_id)->value('subject_name');
        $record_obj['uploaded_by'] = User::where('id', $record->uploaded_by)->value('name');
        $record_obj['is_submitted'] = ($assign_record) ? true : false;
        $record_obj['assignment_message'] = ($record && $record->assignment_message) ? $record->assignment_message : null;
        $assignmentData[] = $record_obj;
      }
    }
    return apiResponse(200, lang('Subject Assignments Fetched Successfully!'), null, $assignmentData);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Syllabus  $syllabus
   * @return \Illuminate\Http\Response
   */
  public function edit(Syllabus $syllabus)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Syllabus  $syllabus
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Syllabus $syllabus)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Syllabus  $syllabus
   * @return \Illuminate\Http\Response
   */
  public function deleteSyllabus($id)
  {
    $exam_details = Syllabus::where('id', $id)->delete();
    if (isset($exam_details)) {
      return apiResponse(200, lang('Syllabus Deleted Successfully!'), null, $exam_details);
    } else {
      return apiResponse(400, lang('Something Went Wrong!'), null, null);
    }
  }
}
