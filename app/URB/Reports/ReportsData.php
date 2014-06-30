<?php namespace URB\Orders;

use URB\Core\VocalEntity;

class ReportsData extends VocalEntity
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'reports_data';

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
	public $timestamps = true;
	
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