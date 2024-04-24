<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportCard extends Model
{
  protected $fillable = ['exam_id', 'student_id', 'class_id', 'grade_pointer', 'obtained_marks', 'obtained_grade', 'obtained_position'];
}
