<?php

/**
 * Orders Model
 */

return array(

	'title' => 'Orders',

	'single' => 'order',

	'model' => 'URB\Orders\Orders',

	'sort' => array(
		'field'=> 'order_date',
		'direction' =>'desc'
		),

	/**
	 * The display columns
	 */
	'columns' => array(
		'id',
		'shipworks_order_id',
		'order_date',
		'ship_name',
		'customer_email' => array(
			'title'=>'Customer Email',
			'relationship' => 'customer',
			'select' => '(:table).email'
			),
		'order_source',
		'number_items' => array(
			'title'=>'Number Items',
			'relationship' => 'items',
			'select' => 'SUM((:table).qty)'
			),
		'order_total' => array(
			'title'=>'Order Total',
			'relationship' => 'items',
			'select' => 'SUM((:table).total)'
			),
		'status' => array(
			'title'=>'Order Status',
			'select' => "IF((:table).status, 'complete', 'incomplete')"
			)
	),

	/**
	 * The filter set
	 */
	'filters' => array(
		'shipworks_order_id',
		'ship_name',
		'bill_name',
		'customer' => array(
			'type'=>'relationship',
			'title' => 'Customer Email',
			'name_field' => 'email',
			'autocomplete' => true,
			),
		'order_date' => array(
			'type'=>'date',
			'title' => 'Order Date',
			),

	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(

		'shipworks_order_id' => array(
			'title'=>'Shipworks Order #',
			'editable'=>false,
			),
		'order_date' => array(
			'title'=>'Order Date',
			'type'=>'date',
			'editable'=>false,
			),
		
		'customers_id' => array(
			'title'=>'Customer',
			'editable'=>false,
			), 
			
		'shipping_address' => array(
			'type'=>"textarea",
			'editable' => false,
			),
		'billing_address' => array(
			'type'=>"textarea",
			'editable' => false,
			),
		'order_source' => array(
			'title'=>'Order Source',
			'editable'=>false,
			), 
		'status' => array(
			'title'=>'Order Status',
			'editable'=>false,
			), 
		)

);