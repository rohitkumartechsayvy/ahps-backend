<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassIncharge extends Model
{
  protected $fillable = ['teacher_id', 'class_id', 'from', 'to', 'changed_by', 'status'];
  protected function checkIncharge($teacher_id, $class_id)
  {
    $get = ClassIncharge::where('teacher_id', $teacher_id)->where('class_id', $class_id)->where('status', 1)->first();
    if (isset($get)) {
      return true;
    } else {
      return false;
    }
  }
}
