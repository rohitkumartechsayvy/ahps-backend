<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use DB;

class Event extends Model
{
  protected $fillable = ['title', 'desc', 'gallery', 'created_by', 'approved_by'];
  protected function validateEvent($inputs)
  {
    $rules = [
      'title' => 'required|min:4',
      'desc' => 'required|min:4'
    ];
    return Validator::make($inputs, $rules);
  }
  protected function fetchEvents()
  {
    return DB::table('events')->select('events.*', 'users.name', 'users.email', 'users.profile_picture', 'users.phone_number', 'events.id as id')->leftJoin('users', 'users.id', 'events.created_by')->get();
  }

  protected function fetchEvent($id)
  {
    return DB::table('events')->select('*', 'events.id as id')->leftJoin('users', 'users.id', 'events.created_by')->where('events.id', $id)->first();
  }
}
