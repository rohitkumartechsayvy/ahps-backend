<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class ClassFeeDetail extends Model
{
  protected $fillable = ['class_id', 'month_id', 'monthly_fee'];
  protected function validateFeeDetails($inputs)
  {
    $rules = [
      'class_id' => 'required',
      'month_id' => 'required',
      'monthly_fee' => 'required|numeric',
    ];
    return Validator::make($inputs, $rules);
  }
}
