<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_items', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('order_id')->unsigned();
			$table->integer('item_id')->unsigned();
			$table->string('shipworks_order_id');
			$table->string('name');
			$table->string('sku');
			$table->string('map_sku');
			$table->integer('qty');
			$table->decimal('unit_price',6,2);
			$table->decimal('total',6,2);
			$table->boolean('product_mapped');
			$table->foreign('shipworks_order_id')->references('shipworks_order_id')->on('orders');
			$table->foreign('order_id')->references('id')->on('orders');
			$table->foreign('item_id')->references('id')->on('items');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('order_items');
	}

}
