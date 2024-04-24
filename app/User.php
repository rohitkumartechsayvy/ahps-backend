<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
  use Notifiable;
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */

  public function getJWTIdentifier()
  {
    return $this->getKey();
  }
  public function getJWTCustomClaims()
  {
    return [];
  }
  protected $fillable = [
    'name', 'email', 'phone_number', 'address', 'password', 'status', 'user_type', 'is_blocked', 'device_token', '_token', 'created_by', 'profile_picture'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  protected function validateUser($inputs)
  {
    $rules = [
      'first_name' => 'required|min:4',
      'last_name' => 'required|min:4',
      'email' => 'required|email|min:4|unique:users',
      'password' => 'required|min:8',
      'device_token' => 'required',
    ];
    return Validator::make($inputs, $rules);
  }
  protected function validateSubAdmin($inputs)
  {
    $rules = [
      'email' => 'required|email|unique:users',
      'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
      'password' => 'required|min:8',
    ];
    return Validator::make($inputs, $rules);
  }

  protected function validateLogin($data)
  {
    return User::where('email', $data['email'])->first();
  }
  protected function adminLogin($data)
  {
    return User::where('email', $data['email'])->first();
  }
  protected function validatePassword($inputs)
  {
    $rules = [
      'password' => 'required|min:8',
    ];
    return Validator::make($inputs, $rules);
  }
  protected function fetchUsers()
  {
    return User::select('id as user_id', 'name', 'phone_number', 'profile_picture', 'address', 'status', 'is_blocked', 'email', 'user_type')->get();
  }
  protected function fetchSubadmins()
  {
    return User::select('id as user_id', 'name', 'phone_number', 'profile_picture', 'address', 'status', 'is_blocked', 'email', 'user_type')->where('user_type', '!=', config('achiever.auth.superadmin_type'))->where('user_type', config('achiever.auth.subadmin_type'))->get();
  }
  protected function fetchAdmins()
  {
    return User::select('id as user_id', 'name', 'phone_number', 'profile_picture', 'address', 'status', 'is_blocked', 'email', 'user_type')->where('user_type', config('achiever.auth.superadmin_type'))->get();
  }
  protected function fetchAccountants()
  {
    return User::select('id as user_id', 'name', 'phone_number', 'profile_picture', 'address', 'status', 'is_blocked', 'email', 'user_type')->where('user_type', '!=', config('achiever.auth.superadmin_type'))->where('user_type', config('achiever.auth.accountant_type'))->get();
  }
  protected function fetchTeachers()
  {
    return User::select('id as user_id', 'name', 'phone_number', 'profile_picture', 'address', 'status', 'is_blocked', 'email', 'user_type')->where('user_type', '!=', config('achiever.auth.superadmin_type'))->where('user_type', config('achiever.auth.teacher_type'))->get();
  }
  protected function fetchStudents()
  {
    return User::select('id as user_id', 'name', 'phone_number', 'profile_picture', 'address', 'status', 'is_blocked', 'email', 'user_type')->where('user_type', '!=', config('achiever.auth.superadmin_type'))->where('user_type', config('achiever.auth.student_type'))->get();
  }
  protected function fetchStudent($id)
  {
    return DB::table('users')->select('users.*', 'student_details.*', 'users.id as id')
      ->leftJoin('student_details', 'student_details.user_id', 'users.id')
      ->leftJoin('student_school_statuses', 'student_school_statuses.student_id', 'users.id')
      ->where('users.id', $id)->first();
  }
  protected function fetchUser($id)
  {
    return User::select('id as user_id', 'name', 'phone_number', 'profile_picture', 'address', 'status', 'is_blocked', 'email', 'user_type')->where('id', $id)->first();
  }
  protected function getAssignedStudents($id)
  {
    return User::select('id as user_id', 'name', 'phone_number', 'profile_picture', 'address', 'status', 'is_blocked', 'email', 'user_type')->whereIn('id', $id)->where('user_type', '!=', config('achiever.auth.superadmin_type'))->where('user_type', config('achiever.auth.student_type'))->get();
  }
}
