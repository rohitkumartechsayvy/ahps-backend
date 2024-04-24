<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeePaymentsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('fee_payments', function (Blueprint $table) {
      $table->id();
      $table->bigInteger('voucher_id');
      $table->string('transaction_id');
      $table->longText('transaction_details');
      $table->string('paid_amount');
      $table->string('payment_mode');
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
    Schema::dropIfExists('fee_payments');
  }
}
