<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('items', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('sku')->unique();
			$table->string('name');
			$table->string('vendor_part_no');
			$table->string('image_url');
			$table->string('item_url');
			$table->decimal('current_price',6,2);
			$table->decimal('current_cost',6,2);
			$table->decimal('current_special',6,2);
			$table->string('manufacturer');
			$table->string('vendor');
			$table->string('type');
			$table->boolean('status');
			$table->integer('mage_id')->unsigned(); // Magento Product Id
			$table->integer('parent_item_id')->unsigned(); // If product sku is no longer in use set new item id to reference
			$table->boolean('is_bundle');
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
		Schema::drop('items');
	}

}
