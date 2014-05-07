<?php

/**
 * Orders Model
 */

return array(

	'title' => 'Customers',

	'single' => 'customer',

	'model' => 'URB\Customers\Customers',

	'sort' => array(
		'field'=> 'id',
		'direction' =>'desc'
		),

	/**
	 * The display columns
	 */
	'columns' => array(
		'id',
		'name',
		'email',
		'phone',
	),

	/**
	 * The filter set
	 */
	'filters' => array(
		'name',
		'email'
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
		'email' => array(
			'type' => 'text',
			'editable'=>false,
			),
		'phone' => array(
			'type' => 'text',
			'editable'=>false,
			),
		),
	'link' => function($model)
	{
		return 'http://agenaastro.com';
	}

);