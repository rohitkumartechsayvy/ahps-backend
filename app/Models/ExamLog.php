<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamLog extends Model
{
  protected $fillable = ['subject_id', 'class_id', 'max_marks', 'passing_marks', 'max_grade', 'passing_grade'];
}
