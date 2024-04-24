<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class TimeTable extends Model
{
  protected $fillable = ['teacher_id', 'class_id', 'subject_id', 'hour_id', 'day_id', 'changed_by', 'from', 'to', 'status'];
  protected function fetchTimeTables()
  {
    return DB::table('time_tables')->select('*', 'time_tables.id as id', 'class_details.class_name as class_name')
      ->leftJoin('users', 'users.id', 'time_tables.teacher_id')
      ->leftJoin('subjects', 'subjects.id', 'time_tables.subject_id')
      ->leftJoin('class_details', 'class_details.id', 'time_tables.class_id')
      ->leftJoin('hours', 'hours.id', 'time_tables.hour_id')
      ->leftJoin('days', 'days.id', 'time_tables.day_id')
      ->get();
  }
  protected function fetchTimeTable($id)
  {
    return DB::table('time_tables')->select('*', 'time_tables.id as id')
      ->leftJoin('users', 'users.id', 'time_tables.teacher_id')
      ->leftJoin('subjects', 'subjects.id', 'time_tables.subject_id')
      ->leftJoin('class_details', 'class_details.id', 'time_tables.class_id')
      ->leftJoin('hours', 'hours.id', 'time_tables.hour_id')
      ->leftJoin('days', 'days.id', 'time_tables.day_id')
      ->where('time_tables.id', $id)
      ->first();
  }
  protected function getTeacherTimeTable($teacher_id)
  {
    return DB::table('time_tables')->select('*', 'time_tables.id as id')
      ->leftJoin('users', 'users.id', 'time_tables.teacher_id')
      ->leftJoin('subjects', 'subjects.id', 'time_tables.subject_id')
      ->leftJoin('class_details', 'class_details.id', 'time_tables.class_id')
      ->leftJoin('hours', 'hours.id', 'time_tables.hour_id')
      ->leftJoin('days', 'days.id', 'time_tables.day_id')
      ->where('time_tables.teacher_id', $teacher_id)
      ->get();
  }
  protected function getStudentTimeTable($class_id)
  {
    return DB::table('time_tables')->select('*', 'time_tables.id as id')
      ->leftJoin('users', 'users.id', 'time_tables.teacher_id')
      ->leftJoin('subjects', 'subjects.id', 'time_tables.subject_id')
      ->leftJoin('class_details', 'class_details.id', 'time_tables.class_id')
      ->leftJoin('hours', 'hours.id', 'time_tables.hour_id')
      ->leftJoin('days', 'days.id', 'time_tables.day_id')
      ->where('time_tables.class_id', $class_id)
      ->get();
  }
  protected function fetchRecord($hour_id, $day_id, $teacher_id)
  {
    return DB::table('time_tables')->select('*', 'time_tables.id as id')
      ->leftJoin('users', 'users.id', 'time_tables.teacher_id')
      ->leftJoin('subjects', 'subjects.id', 'time_tables.subject_id')
      ->leftJoin('class_details', 'class_details.id', 'time_tables.class_id')
      ->leftJoin('hours', 'hours.id', 'time_tables.hour_id')
      ->leftJoin('days', 'days.id', 'time_tables.day_id')
      ->where('time_tables.hour_id', $hour_id)
      ->where('time_tables.day_id', $day_id)
      ->where('time_tables.teacher_id', $teacher_id)
      ->first();
  }
}
