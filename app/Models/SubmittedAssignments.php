<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmittedAssignments extends Model
{
  protected $fillable  = ['student_id', 'assignment_id', 'submitted_assignment'];
}
