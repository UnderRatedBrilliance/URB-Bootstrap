<?php

/**
 * Items Model
 */


return array(

	'title' => 'Items Sales',

	'single' => 'item Sales',

	'model' => 'URB\Items\Items',

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
		),

	'global_actions' => array(

			'export_results' => array(
				'title' => 'Export Results',
				'messages' => array(
						'active'=>'Exporting Results...',
						'success'=>'Results Export Complete!',
						'error' => ' There was an error while exporting the results',
					),
				'action' => function(&$data)
				{
					$dataExport = $data->get(array('id','sku','vendor','manufactuer','name','current_price'))->toArray();

					CSV::with($dataExport)->put(storage_path().'/downloads/data_export.csv','w+'); 
					return Response::download(storage_path().'/downloads/data_export.csv');
				},
				)
		)

);