<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('shipworks_order_id')->unique();
			$table->date('order_date');
			$table->integer('customers_id')->unsigned();
			$table->foreign('customers_id')->references('id')->on('customers');
			$table->string('ship_name');
			$table->string('ship_address1');
			$table->string('ship_address2');
			$table->string('ship_address3');
			$table->string('ship_city');
			$table->string('ship_state');
			$table->string('ship_postal_code');
			$table->string('ship_country_code');
			$table->string('ship_phone');
			$table->string('bill_name');
			$table->string('bill_address1');
			$table->string('bill_address2');
			$table->string('bill_address3');
			$table->string('bill_city');
			$table->string('bill_state');
			$table->string('bill_postal_code');
			$table->string('bill_country_code');
			$table->string('bill_phone');
			$table->string('order_source');
			$table->boolean('status');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('orders');
	}

}
