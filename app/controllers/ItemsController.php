<?php

class ItemsController extends \BaseController {



	protected $layout = 'layouts.base';


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$filters = Input::only('sku','vendor','name');
		$sortBy = Input::get('sortby','id');
		$perPage = Input::get('perpage',50);

		$products = URB\Items\Items::ProductQuery($filters,$sortBy)->paginate($perPage);

		$this->layout->contents = View::make('products.index',compact('products'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$product = URB\Items\Items::with('itemsSold.order')->find($id);

		$this->layout->contents = View::make('products.show',compact('product'));

		//return $customer->toJson();
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}