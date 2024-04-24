<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportCardLogsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('report_card_logs', function (Blueprint $table) {
      $table->id();
      $table->bigInteger('report_card_id');
      $table->bigInteger('subject_id');
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
    Schema::dropIfExists('report_card_logs');
  }
}
