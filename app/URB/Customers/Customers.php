<?php namespace URB\Customers;

use URB\Core\VocalEntity;
use URB\Orders\Orders;

class Customers extends VocalEntity
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'customers';

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
	public function orders() 
	{
		return $this->hasMany('URB\Orders\Orders');
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