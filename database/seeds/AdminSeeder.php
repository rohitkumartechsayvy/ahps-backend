<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('users')->insert([
      'first_name' => 'Super',
      'last_name' => 'Admin',
      'company_name' => 'Super Admin',
      'user_type' => config('resell.auth.admin_type'),
      'status' => config('resell.auth.active'),
      'is_blocked' => config('resell.auth.unblocked'),
      'email' => 'super.admin@yopmail.com',
      'password' => Hash::make('12345678'),
    ]);
  }
}
