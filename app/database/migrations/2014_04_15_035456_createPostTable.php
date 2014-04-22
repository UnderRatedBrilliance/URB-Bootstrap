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
			$table->boolean('status')->default(1);
			
			//Related Fields 
			$table->integer('user_id')->unsigned();

			//Meta Fields
			$table->string('meta_title',80);
			$table->string('meta_description',200);
			$table->string('meta_keywords',255);

			//Meta Data
			$table->binary('meta_data')->nullable();
			$table->dateTime('published_date')->nullable();
			$table->integer('last_edited_by');

			$table->timestamps();
			$table->softDeletes();

			//Foreign Keys
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
