<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

	

/*Route::get('/products',function()
{
	//$items = new URB\Items\ItemsRepository(new URB\Items\Items);

	$items = App::make('ItemsRepository')->getItemsPaginated();
	return $items;
});
*/


Route::any('/shipworkstest',function()
{
	$allInput = Request::getContent();

	$xml = simplexml_load_string($allInput);
	$json = json_encode($xml);
	$array = json_decode($json,TRUE);

	Cache::forever('last_sw_request', $array);
	//Log::info($json);
	$import = App::make('URB\Import\Import');

$import_hash = md5($array['Customer']['Order']['Number'].$array['Customer']['Order']['Date']);
if(!$import->where('unique_hash',$import_hash)->first())
{
	$import->type = 'shipworks_order';
	$import->raw_json_data = $json;
	$import->status = false;
	$import->unique_hash = $import_hash;
	$import->save();
	return 'import processed';
}
else {
	Cache::forever('last_sw_request', 'already stored');
}	
	
});

Route::any('/lastswrequest',function()
{
	return Cache::get('last_sw_request');
	
});

Route::controller('/import','ImportController');
Route::resource('products','ItemsController');
/*//////////////////////////////////////////////////////////////////////////
	Extending FrozenNode/Administrator Routes
//////////////////////////////////////////////////////////////////////////*/		

Route::group(array('prefix' => Config::get('administrator::administrator.uri'), 'before' => 'validate_admin'), function()
{
	//Get Item Display Full Page
		Route::get('{model}/{id}/full', array(
			'as' => 'admin_get_item_full',
			'uses' => 'URB\Admin\Controllers\UrbAdminController@showFull'
		));
});