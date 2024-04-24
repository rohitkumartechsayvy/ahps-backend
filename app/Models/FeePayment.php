<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeePayment extends Model
{
  protected $fillable = ['voucher_id', 'transaction_id', 'transaction_details', 'paid_amount', 'payment_mode'];
}
