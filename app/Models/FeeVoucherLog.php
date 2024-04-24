<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeVoucherLog extends Model
{
  protected $fillable = ['voucher_id', 'charge_id', 'charge_amount'];
}
