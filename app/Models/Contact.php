<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Contact extends Model
{
  protected $fillable = ['name', 'email', 'phone_number', 'message', 'subject'];
  protected function validateInputs($inputs)
  {
    $rules = [
      'email' => 'required|email|unique:contacts',
      'phone_number' => 'required|unique:contacts',
      'name' => 'required|min:8',
      'subject' => 'required',
      'message' => 'required',
    ];
    return Validator::make($inputs, $rules);
  }
}
