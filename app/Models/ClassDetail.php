<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClassDetail extends Model
{
  protected $fillable = ['class_name'];
  protected function validateClass($inputs)
  {
    $rules = [
      'class_name' => 'required|unique:class_details'
    ];
    return Validator::make($inputs, $rules);
  }
  protected function validateEditClass($inputs, $id = null)
  {
    $rules = [
      'class_name' => 'required|unique:class_details,class_name,' . $id
    ];
    return Validator::make($inputs, $rules);
  }
  protected function fetchClass($id)
  {
    return DB::table('class_details')
      ->select('class_details.*', 'class_incharges.*', 'class_incharges.id as inc_table_id', 'users.name as teacher_name', 'class_details.id as id')
      ->leftJoin('class_incharges', 'class_incharges.class_id', 'class_details.id')
      ->leftJoin('users', 'class_incharges.teacher_id', 'users.id')
      ->where('class_details.id', $id)->first();
  }

  protected function getAssignedClasses($id)
  {
    return DB::table('class_details')
      ->select('class_details.*', 'class_incharges.*', 'class_incharges.id as inc_table_id', 'users.name as teacher_name', 'class_details.id as id')
      ->leftJoin('class_incharges', 'class_incharges.class_id', 'class_details.id')
      ->leftJoin('users', 'class_incharges.teacher_id', 'users.id')
      ->where('class_incharges.teacher_id', $id)->where('class_incharges.status', 'active')->get();
  }
  protected function getSubjectClasses($id)
  {
    return DB::table('time_tables')->select('*', 'time_tables.id as id')
      ->leftJoin('users', 'users.id', 'time_tables.teacher_id')
      ->leftJoin('subjects', 'subjects.id', 'time_tables.subject_id')
      ->leftJoin('class_details', 'class_details.id', 'time_tables.class_id')
      ->leftJoin('hours', 'hours.id', 'time_tables.hour_id')
      ->leftJoin('days', 'days.id', 'time_tables.day_id')
      ->where('time_tables.teacher_id', $id)
      ->get()->groupBy('class_id');
  }
  protected function getStudentByClass($class_id)
  {
    return DB::table('users')->select('users.*', 'student_details.*', 'users.id as id')
      ->leftJoin('student_details', 'student_details.user_id', 'users.id')
      ->leftJoin('student_school_statuses', 'student_school_statuses.student_id', 'users.id')
      ->where('student_school_statuses.class_id', $class_id)->where('student_school_statuses.status', 'active')->get();
  }
}
