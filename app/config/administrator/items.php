<?php

/**
 * Items Model
 */


return array(

	'title' => 'Items',

	'single' => 'item',

	'model' => 'URB\Items\Items',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id',
		'sku',
		'vendor'
	),

	/**
	 * The filter set
	 */
	'filters' => array(
		'id',
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