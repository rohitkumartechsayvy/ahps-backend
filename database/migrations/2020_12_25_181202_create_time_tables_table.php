<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeTablesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('time_tables', function (Blueprint $table) {
      $table->id();
      $table->mediumInteger('teacher_id')->nullable();
      $table->mediumInteger('subject_id');
      $table->mediumInteger('hour_id');
      $table->mediumInteger('class_id');
      $table->mediumInteger('day_id');
      $table->mediumInteger('changed_by')->nullable();
      $table->timestamp('from');
      $table->timestamp('to')->nullable();
      $table->enum('status', ['active', 'inactive'])->default('active');
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
    Schema::dropIfExists('time_tables');
  }
}
