<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('users', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('email')->unique()->nullable();
      $table->string('phone_number')->unique()->nullable();
      $table->string('profile_picture')->nullable();
      $table->enum('status', ['active', 'inactive'])->default('active');
      $table->enum('is_blocked', ['unblocked', 'blocked'])->default('unblocked');
      $table->enum('user_type', ['super_admin', 'subadmin', 'accountant', 'teacher', 'student', 'user']);
      $table->timestamp('email_verified_at')->nullable();
      $table->string('password');
      $table->string('address', 400)->nullable();
      $table->mediumInteger('created_by')->nullable();
      $table->rememberToken();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('users');
  }
}
