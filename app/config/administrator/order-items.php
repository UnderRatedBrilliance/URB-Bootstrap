<?php

/**
 * Orders Model
 */

return array(

	'title' => 'Order Items',

	'single' => 'Order Item',

	'model' => 'URB\Orders\OrderItems',

	'sort' => array(
		'field'=> 'id',
		'direction' =>'desc'
		),

	/**
	 * The display columns
	 */
	'columns' => array(
		'id',
		'order_id',
		'shipworks_order_id',
		'sku',
		'name',
		'qty',
		'unit_price',
		'total',
		'map_sku',
		'item_id',
		'item_mapped'
	),

	/**
	 * The filter set
	 */
	'filters' => array(
		'order_id',
		'shipworks_order_id',
		'sku',
		'name',
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(

		'id' => array(
			'type' => 'key'
			),
		'name' => array(
			'title'=>'Name',
			),
		/*
		'email' => array(
			'type' => 'text',
			'editable'=>false,
			),
		'phone' => array(
			'type' => 'text',
			'editable'=>false,
			),
			*/
		),
	'link' => function($model)
	{
		return 'http://agenaastro.com';
	}

);