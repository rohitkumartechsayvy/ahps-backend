<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
  // FUNCTION TO GET ALL THE USERS FOR ADMIN
  public function users()
  {
    $users = User::get();
    dd($users);
    if (isset($users) && count($users) > 0) {
      return view('admin.users', compact('users'));
    }
  }
  // FUNCTION TO GET ALL THE USERS FOR ADMIN

  // FETCH USER DETAILS
  public function userDetail($id)
  {
    $user_details = User::where('id', $id)->first();
    dd($user_details);
  }
  // FETCH USER DETAILS
}
