<?php

/**
 * Users Model
 */


return array(

	'title' => 'Users',

	'single' => 'User',

	'model' => 'URB\Users\User',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id',
		'sku',
		'vendor',
		'name',
		'current_price',
		'sold_in_7',
		'sold_in_14',
		'sold_in_30',
		'sold_in_90',
		'sold_in_180',
		'sold_in_year',
		'sold_all_time'
	),

	/**
	 * The filter set
	 */
	'filters' => array(
		'sku',
		'vendor',
		'name'
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
		'sku',
		'name',
		'manufactuer'
		)

);