<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentDetail extends Model
{
  protected $fillable = [
    'user_id', 'dob', 'father_name', 'mother_name', 'father_id', 'mother_id', 'staff_child', 'nationality', 'relation', 'religion', 'category', 'adhaar_card', 'gender', 'admission_no', 'roll_no', 'joining_date', 'guardian', 'occupation', 'transfer_certificate', 'migration_certificate', 'birth_certificate', 'marksheet_certificate', 'adhaar_card_certificate', 'last_school', 'adhaar_card'
  ];
}
