<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
  protected $fillable = ['student_id', 'class_id', 'date', 'status'];
  protected function AttendanceMarked($class_id)
  {
    $records = Attendance::where('class_id', $class_id)->whereDay('created_at', now()->day)->get();
    if (isset($records) && count($records) > 0) {
      return true;
    } else {
      return false;
    }
  }
}
