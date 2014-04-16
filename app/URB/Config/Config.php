<?php namespace URB\Config;

use URB\Core\Entity;

class Config extends Entity
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'config';


	 /**
	* Attributes that are fillable by massassignment
	*
	* @var array
	*/
	 protected $fillable = array('name','value');

	 /**
	 * Model Validation Rules
	 *
	 * @return array of rules used for input sanitation and model validation
	 */
	 protected $validationRules = array();

	
}