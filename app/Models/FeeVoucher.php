<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeVoucher extends Model
{
  protected $fillable = ['student_id', 'due_date', 'issue_date', 'total_fee', 'fee_status', 'fee_month', 'session_id'];
}
