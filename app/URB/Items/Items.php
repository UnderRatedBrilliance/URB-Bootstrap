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
	protected $appends = array('sold_in_7','sold_in_14','sold_in_30','sold_in_90','sold_in_180','sold_in_year','sold_all_time');
    
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

	/*//////////////////////////////////////////////////////////////////////////
	Model Relationships
	//////////////////////////////////////////////////////////////////////////*/
	public function itemsSold() {
			return $this->hasMany('URB\Orders\OrderItems','item_id');
		}
	
	/*//////////////////////////////////////////////////////////////////////////
	Model Query Scopes
	//////////////////////////////////////////////////////////////////////////*/

	/**
	* Query Scope filter by item attributes
	* @var \Illuminate\Database\Query $query 
	* @var array $filters
	* @var mixed $sortBy - accepts both string and array of values to sort by
	*/
	public function scopeProductQuery($query,$filters = array(),$sortby = 'id')
	{
		if(!empty($filters)) {
			foreach($filters as $key => $filter) {
				if($filter){
					$query->where($key,'LIKE','%'.$filter.'%');
				}				
			}
		}
		return $query->orderBy($sortby);
	}

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
	public function scopeReturnSalesCount($query, $days = array(),$allSold = true)
	{

		// Default Day Values
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

		if(!isset($days[0]) AND $allSold === true)
		{
			$days[0] = 'Sold All Time';
		}
			
			// Retrieve database prefix to manually prefix Raw Select Queries
			$grammar = $query->getQuery()->getGrammar();
			$db_prefix = $grammar->getTablePrefix();


			$query->addSelect($this->getTable().'.id', $this->getTable().'.sku');

			// Add Select Columns to query based on Days array
			foreach($days as $day =>$label)
			{
				if($day == 0)
			{
				$query->addSelect(DB::raw("SUM(CASE WHEN ".$db_prefix."orders.order_date <= '". \Carbon\Carbon::now()->subDays($day)->format('Y-m-d')."' THEN ".$db_prefix."order_item.qty ELSE 0 END) as '".$label."'"));
				continue;
			}
				$query->addSelect(DB::raw("SUM(CASE WHEN ".$db_prefix."orders.order_date >= '". \Carbon\Carbon::now()->subDays($day)->format('Y-m-d')."' THEN ".$db_prefix."order_item.qty ELSE 0 END) as '".$label."'"));
				
			}
			
			$query->join('order_item','items.id','=','order_item.item_id')
			->join('orders','order_item.order_id','=','orders.id')
			->where('orders.status',1)
			->groupBy('item.sku')
			->orderBy('item.sku', 'asc');
			

	}
	/*//////////////////////////////////////////////////////////////////////////
	Model Public Methods
	//////////////////////////////////////////////////////////////////////////*/		
	
	public function howManySoldIn($days = 90) {

		$date = new \DateTime('today');
		$date->modify('-'.$days.' day');

		$orderItems = $this->itemsSold()->where('item_id',$this->id)
								->join('orders','order_item.order_id','=','orders.id');
								if(!$days == 0)
								{
									$orderItems = $orderItems->where('orders.order_date','>=',$date->format('Y-m-d'));
								}
								
								$orderItems = $orderItems->where('orders.status',1)
								->sum('qty');
		return $orderItems;
	}

	/*//////////////////////////////////////////////////////////////////////////
	Custom Virtual Attributes that are appended to the model
	//////////////////////////////////////////////////////////////////////////*/

	public function getSoldIn7Attribute()
	{
		return $this->howManySoldIn(7);
	}

	public function getSoldIn14Attribute()
	{
		return $this->howManySoldIn(14);
	}

	public function getSoldIn30Attribute()
	{
		return $this->howManySoldIn(30);
	}

	public function getSoldIn90Attribute()
	{
		return $this->howManySoldIn(90);
	}

	public function getSoldIn180Attribute()
	{
		return $this->howManySoldIn(180);
	}

	public function getSoldInYearAttribute()
	{
		return $this->howManySoldIn(365);
	}

	public function getSoldAllTimeAttribute()
	{
		return $this->howManySoldIn(0);
	}
	
}