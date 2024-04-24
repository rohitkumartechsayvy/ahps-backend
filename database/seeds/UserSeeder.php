<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('users')->insert([
      'name' => 'Super Admin',
      'email' => 'superAdmin@gmail.com',
      'password' => Hash::make('password'),
      'status' => 1,
      'is_blocked' => 1,
      'user_type' => 1,
      'email_verified_at' => date('Y-m-d h:i:s'),
    ]);
  }
}
