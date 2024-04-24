<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportCardLog extends Model
{
  protected $fillable = ['report_card_id', 'subject_id', 'max_marks', 'obtained_marks', 'obtained_grade', 'obtained_position'];
}
