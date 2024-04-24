<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('assignments', function (Blueprint $table) {
      $table->id();
      $table->bigInteger('class_id');
      $table->bigInteger('subject_id');
      $table->bigInteger('uploaded_by');
      $table->string('assignment_message');
      $table->string('assignment');
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
    Schema::dropIfExists('assignments');
  }
}
