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
			$table->integer('qty');
			$table->decimal('unit_price',6,2);
			$table->decimal('total',6,2);
			$table->integer('order_id')->unsigned();
			$table->integer('item_id')->unsigned();
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
		Schema::drop('order_item');
	}

}
