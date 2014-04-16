<?php namespace URB\Posts;

use URB\Core\Entity;
use \User;

class Posts extends Entity
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'posts';

	/**
	* Soft Deletes Enabled for this model. 
	*
	* @var boolean
	*/
	 protected $softDelete = true;

	 /**
	* Attributes that are fillable by massassignment
	*
	* @var array
	*/
	 protected $fillable = array(
			'title',
			'slug',
			'content',
			'excerpt',
			'custom_data',
			'status',
			'user_id',
			'meta_title',
			'meta_description',
			'meta_keywords'
		);

	 /**
	 * Model Validation Rules
	 *
	 * @return array of rules used for input sanitation and model validation
	 */
	 protected $validationRules = array();

	public function user()
	{
		return $this->belongsTo('User');
	}
}