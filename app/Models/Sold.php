<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Sold extends Model
{
  protected $fillable = ['sold_value', 'sale_fee', 'shipping_fee', 'taxes', 'item_id'];
  protected function checkSold($item_id)
  {
    return Sold::where('item_id', $item_id)->first();
  }
  protected function validateSold($inputs)
  {
    $rules = [
      'item_id' => 'required',
      'sold_value' => 'required',
      'sale_fee' => 'required',
      'shipping_fee' => 'required',
      'taxes' => 'required'
    ];
    return Validator::make($inputs, $rules);
  }
}
