<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_item', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('shipworks_order_id');
			$table->string('name');
			$table->string('sku');
			$table->string('map_sku');
			$table->integer('qty');
			$table->decimal('unit_price',6,2);
			$table->decimal('total',6,2);
			$table->boolean('product_mapped');
			$table->foreign('shipworks_order_id')->references('shipworks_order_id')->on('orders');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('order_item');
	}

}
