<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title')->index();
			$table->string('slug')->index();
			$table->text('content');
			$table->text('excerpt');
			$table->binary('custom_data')->nullable(); //Store additional fields
			$table->boolean('status');
			
			//Related Fields 
			$table->integer('user_id')->unsigned();

			//Meta Fields
			$table->string('meta_title',80);
			$table->string('meta_description',200);
			$table->string('meta_keywords',255);

			//Meta Data
			$table->integer('last_edited_by');
			$table->timestamps();
			
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('posts');
	}

}
