<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration {

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
			$table->string('name');
			$table->string('email')->unique();
			$table->string('phone');	
			$table->decimal('avg_order_total',6,2);
			$table->decimal('highest_order_total',6,2);
			$table->decimal('lowest_order_total',6,2);
			$table->decimal('avg_time_between_orders',6,2);
			$table->decimal('estimated_profit',6,2);
			$table->decimal('avg_shipping_cost',6,2);
			$table->decimal('estimate_total_shipping_cost',6,2);
			$table->date('last_purchase_date');		
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
