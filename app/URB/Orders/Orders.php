<?php namespace URB\Orders;

use URB\Core\VocalEntity;

class Orders extends VocalEntity
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'orders';

	/**
	* Soft Deletes Enabled for this model. 
	*
	* @var boolean
	*/
	protected $softDelete = false;

	/**
	* Timestamps Enabled for this model. 
	*
	* @var boolean
	*/
	public $timestamps = false;


	//Apends properties to toString and toJson output that do not have corresponding columns
	protected $appends = array('shipping_address','billing_address');
    
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
		return $this->hasMany('URB\Orders\OrderItems','order_id');
	}

	public function customer() 
	{
		return $this->belongsTo('URB\Customers\Customers','customers_id');
	}
	
	/*//////////////////////////////////////////////////////////////////////////
	Model Query Scopes
	//////////////////////////////////////////////////////////////////////////*/

	/*//////////////////////////////////////////////////////////////////////////
	Model Protected Methods
	//////////////////////////////////////////////////////////////////////////*/

	 protected function getAddress($type = 'ship')
	{
		$address = $this[$type.'_address1']."\n";
		$address .= ($this[$type.'_address2'] ? $this[$type.'_address2']."\n":'');
		$address .= ($this[$type.'_address3'] ? $this[$type.'_address3']."\n":'');
		$address .= $this[$type.'_city'].', ';
		$address .= $this[$type.'_state'].' '.$this[$type.'_postal_code']."\n";
		$address .= ($this[$type.'_country_code'] ? $this[$type.'_country_code']:'');

		return $address;
	}

	/*//////////////////////////////////////////////////////////////////////////
	Model Public Methods
	//////////////////////////////////////////////////////////////////////////*/		
	

	

	/*//////////////////////////////////////////////////////////////////////////
	Custom Virtual Attributes that are appended to the model
	//////////////////////////////////////////////////////////////////////////*/
	
	public function getShippingAddressAttribute()
	{
		return $this->getAddress('ship');
	}

	public function getBillingAddressAttribute()
	{
		return $this->getAddress('bill');
	}
}