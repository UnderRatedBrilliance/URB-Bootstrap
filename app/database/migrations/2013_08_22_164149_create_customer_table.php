<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('first_name');
			$table->string('last_name');
			$table->string('middle_name');
			$table->string('company');
			$table->string('email')->unique();
			$table->string('address1');
			$table->string('address2');
			$table->string('address3');
			$table->string('city');
			$table->string('state');
			$table->string('postal_code');
			$table->string('country_code');
			$table->string('phone');
			$table->string('fax');
			$table->string('website');			
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
		Schema::drop('customers');
	}

}
