<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaidToStudentDetailsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('student_details', function (Blueprint $table) {
      $table->string('nationality');
      $table->string('religion');
      $table->enum('category', ['General', 'OBC', 'SC', 'ST']);
      $table->string('adhaar_card');
      $table->enum('gender', ['female', 'male', 'other']);
      $table->string('admission_no');
      $table->string('roll_no');
      $table->string('joining_date');
      $table->string('guardian')->nullable();
      $table->string('relation')->nullable();
      $table->string('occupation');
      $table->string('last_school')->nullable();
      $table->enum('transfer_certificate', ['no', 'yes']);
      $table->enum('migration_certificate', ['no', 'yes']);
      $table->enum('birth_certificate', ['no', 'yes']);
      $table->enum('marksheet_certificate', ['no', 'yes']);
      $table->enum('adhaar_card_certificate', ['no', 'yes']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('student_details', function (Blueprint $table) {
      //
    });
  }
}
