<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateImportTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('import', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('type');
			$table->binary('raw_json_data');
			$table->boolean('status');
			$table->string('unique_hash')->unique();
			$table->text('errors');
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
		Schema::drop('import');
	}

}
