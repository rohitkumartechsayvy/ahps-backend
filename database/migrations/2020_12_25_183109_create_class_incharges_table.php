<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassInchargesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('class_incharges', function (Blueprint $table) {
			$table->id();
			$table->mediumInteger('teacher_id');
			$table->mediumInteger('class_id');
			$table->timestamp('from');
			$table->timestamp('to')->nullable();
			$table->mediumInteger('changed_by');
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
		Schema::dropIfExists('class_incharges');
	}
}
