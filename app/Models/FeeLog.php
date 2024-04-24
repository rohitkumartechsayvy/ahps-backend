<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeLog extends Model
{
  protected $fillable = ['fee_id', 'class_id', 'amount'];
}
