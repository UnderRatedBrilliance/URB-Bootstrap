<?php namespace URB\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Validator;
use Illuminate\Support\MessageBag;

use URB\Core\Exceptions\NoValidationRulesFoundException;
use URB\Core\Interfaces\ValidatorInterface;
use URB\Core\Interfaces\BaseEntityInterface;

abstract class Entity extends Model implements BaseEntityInterface
{

	 /**
     * Validation rules
     * 
     * @var Array
     */
	protected $validationRules = array();

	 /**
     * Validator instance
     * 
     * @var IH\Core\Interfaces\ValidatorInterface
     */
	protected $validator; 

	 /**
     * Error message bag
     * 
     * @var Illuminate\Support\MessageBag
     */
	protected $errors;

	public function __construct(array $attributes = array(), ValidatorInterface $validator = null)
	{
		parent::__construct($attributes);

		// If validator was passed to constructor store in validator property if not create new Laravel Validator class
		$this->validator = $validator ?: \App::make('validator'); 
	}

	/**
     * Validates current attributes against rules
     */
	public function isValid()
	{
		if(! isset($this->validationRules))
		{
			throw new NoValidationRulesFoundException('no validation rule array defined in class ' . get_called_class());
		}

		// load Validator with attributes and rules 
		$this->validator->make($this->attributes, $this->getPreparedRules());

		// Validation passes return true
		if($this->validator->passes())
		{
			return true;
		}
		
		// If validation fails set Error Messages 
		$this->setErrors($this->validator->messages());

		return false;
	}
	/**
	* Validate then save model to database
	*
	* @param array $options
	* @return bool
	*/
	public function save(array $options = array()) 
	{
		if(! $this->isValid())
		{
			return false;
		}
		return parent::save($options);
	}

	/**
	* Set error message bag 
	*
	* @var Illuminate\Support\MessageBag
	*/
	public function setErrors(MessageBag $errors) 
	{
		$this->errors = $errors;
	}

	/**
	* Retrieve error message bag
	*/
	public function getErrors()
	{
		return $this->errors;
	}

	/**
     * Inverse of wasSaved
     */
    public function hasErrors()
    {
        return ! empty($this->errors);
    }

    /**
     * Prepare validation rules before running validation 
     */
    protected function getPreparedRules()
    {
    	return $this->buildUniqueExclusionRules($this->validationRules);
    }

     /**
     *
     * This method was supplied from Laravelbook/Ardent
     * @link https://github.com/laravelbook/ardent
     *
     * When given an ID and a Laravel validation rules array, this function
     * appends the ID to the 'unique' rules given. The resulting array can
     * then be fed to a Ardent save so that unchanged values
     * don't flag a validation issue. Rules can be in either strings
     * with pipes or arrays, but the returned rules are in arrays.
     *
     * @param int   $id
     * @param array $rules
     *
     * @return array Rules with exclusions applied
     */
    protected function buildUniqueExclusionRules(array $rules = array()) {
      
        if (!count($rules))
          $rules = static::$rules;

        foreach ($rules as $field => &$ruleset) {
            // If $ruleset is a pipe-separated string, switch it to array
            $ruleset = (is_string($ruleset))? explode('|', $ruleset) : $ruleset;

            foreach ($ruleset as &$rule) {
              if (strpos($rule, 'unique') === 0) {
                $params = explode(',', $rule);

                $uniqueRules = array();
                
                // Append table name if needed
                $table = explode(':', $params[0]);
                if (count($table) == 1)
                  $uniqueRules[1] = $this->table;
                else
                  $uniqueRules[1] = $table[1];
               
                // Append field name if needed
                if (count($params) == 1)
                  $uniqueRules[2] = $field;
                else
                  $uniqueRules[2] = $params[1];

                if (isset($this->primaryKey)) {
                  $uniqueRules[3] = $this->{$this->primaryKey};
                  $uniqueRules[4] = $this->primaryKey;
                }
                else {
                  $uniqueRules[3] = $this->id;
                }
       
                $rule = 'unique:' . implode(',', $uniqueRules);  
              } // end if strpos unique
              
            } // end foreach ruleset
        }
        
        return $rules;
    }

    public function getFillable()
    {
    	return $this->fillable;
    }
}