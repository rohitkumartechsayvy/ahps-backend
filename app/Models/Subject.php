<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Subject extends Model
{
  protected $fillable = ['subject_name'];
  protected function validateSubject($inputs)
  {
    $rules = [
      'subject_name' => 'required|unique:subjects|regex:/^[\pL\s\-]+$/u',
    ];
    return Validator::make($inputs, $rules);
  }
  protected function validateEditSubject($inputs, $id = null)
  {
    $rules = [
      'subject_name' => 'required|regex:/^[\pL\s\-]+$/u|unique:subjects,subject_name,' . $id
    ];
    return Validator::make($inputs, $rules);
  }
  protected function fetchSubject($id)
  {
    return Subject::where('id', $id)->first();
  }
}
