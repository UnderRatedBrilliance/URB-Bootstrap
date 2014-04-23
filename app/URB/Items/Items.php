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
	public function scopeFilterAndSortBy($query,$filters = array(),$sortBy = 'id')
	{
		if(!empty($filters)) {
			foreach($filters as $key => $filter) {
				if($filter){
					$query->where($key,'LIKE','%'.$filter.'%');
				}				
			}
		}
		return $query->orderBy($sortBy);
	}

	public function returnSalesCount($days = array())
	{
		if(empty($days))
		{
			$days = array(
					'Sold in 7 Days' => 7,
					'Sold in 14 Days' => 14,
					'Sold in 30 Days' => 30,
					'Sold in 90 Days' => 90,
					'Sold in 180 Days' => 180,
					'Sold in 1 Year'  => 365,
					'Sold All Time'  => 0
				);
		}
		$rawSQL = " {$this->table}.sku,";
		foreach($days as $label=>$day)
		{
			$rawSQL =. "SUM(CASE WHEN orders.order_date >= {\Carbon\Carbon::createFormFormat('Y-m-d',\Carbon\Carbon::now()->subDays($day)))} THEN order_item.qty ELSE 0 END) as '{$label}',";
		}
		return $this->model->select($rawSQL))
			->join('orders','order_item.order_id','=','orders.id')
			->where('orders.status',1)
			->groupBy('sku')
			->orderBy('sku', 'desc')
			->get();
	}
}