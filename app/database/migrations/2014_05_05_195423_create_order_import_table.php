<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderImportTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_import', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('order_id');
			$table->string('order_date');
			$table->string('local_status');
			$table->string('online_status');
			$table->integer('item_qty');
			$table->string('item_name');
			$table->string('item_code');
			$table->string('item_sku');
			$table->decimal('item_total',6,2);
			$table->decimal('shipping_total',6,2);
			$table->string('ship_name');
			$table->string('ship_address1');
			$table->string('ship_address2');
			$table->string('ship_address3');
			$table->string('ship_city');
			$table->string('ship_state');
			$table->string('ship_postal_code');
			$table->string('ship_country_code');
			$table->string('ship_phone');
			$table->string('ship_email');
			$table->string('bill_name');
			$table->string('bill_address1');
			$table->string('bill_address2');
			$table->string('bill_address3');
			$table->string('bill_city');
			$table->string('bill_state');
			$table->string('bill_postal_code');
			$table->string('bill_country_code');
			$table->string('bill_phone');
			$table->string('bill_email');
			$table->boolean('import_status');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('order_import');
	}

}
