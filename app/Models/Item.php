<?php

namespace App\Models;

use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Item extends Model
{
  protected $fillable = ['item_name', 'price', 'qty', 'date', 'sold_at', 'location', 'location_lat', 'location_long', 'sku', 'item_img', 'status', 'is_sold', 'user_id', 'created_by'];
  protected function validateItem($inputs)
  {
    $rules = [
      'item_name' => 'required|min:4|unique:items',
      'price' => 'required|numeric',
      'qty' => 'required',
      'sku' => 'nullable|unique:items',
    ];
    return Validator::make($inputs, $rules);
  }
  protected function updateItem($inputs, $id)
  {
    $rules = [
      'item_name' => 'min:4|unique:items,id,' . $id,
      'price' => 'numeric',
      'sku' => 'unique:items,id,' . $id,
    ];
    return Validator::make($inputs, $rules);
  }
  public function UserDetails()
  {
    return $this->belongsTo('App\User', 'user_id', 'id');
  }
  public function SoldDetails()
  {
    return $this->belongsTo('App\Models\Sold', 'id', 'item_id');
  }
}
