<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentSchoolStatus extends Model
{
    protected $fillable = ['student_id', 'class_id', 'session_id', 'status'];
}
