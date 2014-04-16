<?php namespace URB\Core\Interfaces;

interface ValidatorInterface
{

	// Pass values to be validated
	public function make(array $data, array $rules, array $messages = array(), array $customAttributes = array());

	// Return True if all attributes passed validation
	public function passes();

	// Return True if any attributes fail validation 
	public function fails();

	// Return MessageBag Instance 
	public function messages();
}