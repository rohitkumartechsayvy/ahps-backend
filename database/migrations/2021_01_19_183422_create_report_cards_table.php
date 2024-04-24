<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportCardsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('report_cards', function (Blueprint $table) {
      $table->id();
      $table->bigInteger('exam_id');
      $table->bigInteger('student_id');
      $table->bigInteger('class_id');
      $table->string('grade_pointer');
      $table->string('obtained_marks');
      $table->enum('obtained_grade', ['A+', 'A', 'B', 'C', 'D', 'E']);
      $table->string('obtained_position');
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
    Schema::dropIfExists('report_cards');
  }
}
