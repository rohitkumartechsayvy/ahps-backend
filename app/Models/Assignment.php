<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
  protected $fillable = ['class_id', 'subject_id', 'uploaded_by', 'assignment', 'assignment_message'];
}
