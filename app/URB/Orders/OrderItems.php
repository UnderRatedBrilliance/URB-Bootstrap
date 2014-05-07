<?php namespace URB\Orders;

use URB\Core\VocalEntity;

class OrderItems extends VocalEntity
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'order_item';

	/**
	* Soft Deletes Enabled for this model. 
	*
	* @var boolean
	*/
	protected $softDelete = false;

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

	/*//////////////////////////////////////////////////////////////////////////
	Model Relationships
	//////////////////////////////////////////////////////////////////////////*/
	public function items() 
	{
		return $this->hasMany('OrderItem');
	}

	public function customer() 
	{
		$this->belongsTo('Customers','customers_id');
	}
	
	/*//////////////////////////////////////////////////////////////////////////
	Model Query Scopes
	//////////////////////////////////////////////////////////////////////////*/


	/*//////////////////////////////////////////////////////////////////////////
	Model Public Methods
	//////////////////////////////////////////////////////////////////////////*/		
	

	/*//////////////////////////////////////////////////////////////////////////
	Custom Virtual Attributes that are appended to the model
	//////////////////////////////////////////////////////////////////////////*/
	
}