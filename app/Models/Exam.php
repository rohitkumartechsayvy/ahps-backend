<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
  protected $fillable = ['exam_title', 'exam_month', 'exam_type', 'exam_status'];
}
