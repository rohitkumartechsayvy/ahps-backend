<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamLogsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('exam_logs', function (Blueprint $table) {
      $table->id();
      $table->bigInteger('subject_id');
      $table->bigInteger('class_id');
      $table->string('max_marks');
      $table->string('passing_marks');
      $table->enum('max_grade', ['A+', 'A', 'B', 'C', 'D', 'E']);
      $table->enum('passing_grade', ['A+', 'A', 'B', 'C', 'D', 'E']);
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
    Schema::dropIfExists('exam_logs');
  }
}
