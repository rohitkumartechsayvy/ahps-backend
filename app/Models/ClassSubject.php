<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ClassSubject extends Model
{
  protected $fillable = ['subject_id', 'class_id'];
  protected function getSubjects($class_id)
  {
    return DB::table('class_subjects')->select('class_subjects.*', 'class_subjects.id as id', 'subjects.*')
      ->join('subjects', 'subjects.id', 'class_subjects.subject_id')->where('class_subjects.class_id', $class_id)->get();
  }
}
