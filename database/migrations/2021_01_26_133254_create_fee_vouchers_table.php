<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeeVouchersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('fee_vouchers', function (Blueprint $table) {
      $table->id();
      $table->bigInteger('student_id');
      $table->string('due_date');
      $table->string('issue_date');
      $table->string('total_fee');
      $table->enum('fee_status', ['pending', 'paid']);
      $table->string('fee_month');
      $table->bigInteger('session_id');
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
    Schema::dropIfExists('fee_vouchers');
  }
}
