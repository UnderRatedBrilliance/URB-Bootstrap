<?php namespace URB\Items;

use URB\Core\VocalEntity;

class Items extends VocalEntity
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'items';

	/**
	* Soft Deletes Enabled for this model. 
	*
	* @var boolean
	*/
	protected $softDelete = true;

	//Apends properties to toString and toJson output that do not have corresponding columns
	protected $appends = array();
    
	 /**
	* Attributes that are fillable by massassignment
	*
	* @var array
	*/
	 protected $fillable = array();

	/**
	* Model Validation Rules
	*
	* @return array of rules used for input sanitation and model validation
	*/
	public $rules = array();

	/**
	* Query Scope filter query to only show active items
	* @var \Illuminate\Database\Query
	*/
	public function scopeActiveItems($query)
	{
		$query->where('status',1);
	}
	
	/**
	* Query Scope set query filter and sortby column
	* @var \Illuminate\Database\Query
	*/
	public function scopeReturnSalesCount($query, $days = array())
	{
		if(empty($days))
		{
			$days = array(
					7 =>'Sold in 7 Days',
					14 =>'Sold in 14 Days',
					30 =>'Sold in 30 Days',
					90 =>'Sold in 90 Days',
					180 =>'Sold in 180 Days',
					365 =>'Sold in 1 Year',
					 0  => 'Sold All Time'
				);
		}

		if(!isset($days[0]))
		{
			$days[0] = 'Sold All Time';
		}

		$rawSQL = "test_product.id,test_products.sku,";

		foreach($days as $day=>$label)
		{
			if($day == 0)
			{
				$rawSQL .= "SUM(CASE WHEN test_orders.order_date <= '". \Carbon\Carbon::now()->subDays($day)->format('Y-m-d')."' THEN test_order_item.qty ELSE 0 END) as '".$label."'";
				continue;
			}
			$rawSQL .= "SUM(CASE WHEN test_orders.order_date >= '". \Carbon\Carbon::now()->subDays($day)->format('Y-m-d')."' THEN test_order_item.qty ELSE 0 END) as '".$label."',";
		}

			$query->select(DB::raw($rawSQL))
			->join('order_item','products.id','=','order_item.products_id')
			->join('orders','order_item.order_id','=','orders.id')
			->where('orders.status',1)
			->groupBy('products.sku')
			->orderBy('products.sku', 'asc');


	}
}