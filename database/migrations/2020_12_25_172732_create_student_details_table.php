<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentDetailsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('student_details', function (Blueprint $table) {
      $table->id();
      $table->mediumInteger('user_id');
      $table->timestamp('dob');
      $table->string('father_name');
      $table->string('mother_name');
      $table->mediumInteger('father_id')->nullable();
      $table->mediumInteger('mother_id')->nullable();
      $table->enum('staff_child', ['no', 'yes'])->default('no');
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
    Schema::dropIfExists('student_details');
  }
}
