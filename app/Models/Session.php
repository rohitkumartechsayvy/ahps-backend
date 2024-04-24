<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Session extends Model
{
  protected $fillable = ['from', 'to', 'session_status'];
  protected function validateSession($inputs)
  {
    $rules = [
      'from' => 'required|unique:sessions',
      'to' => 'required|unique:sessions',
    ];
    return Validator::make($inputs, $rules);
  }
}
