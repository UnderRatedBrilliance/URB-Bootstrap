<?php namespace URB\Posts;

use URB\Core\VocalEntity;
use \User;

class Posts extends VocalEntity
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

	//Apends properties to toString and toJson output that do not have corresponding columns
	protected $appends = array('post_url');

	public static $sluggable = array(
        'build_from' => 'title',
        'save_to'    => 'slug',
        'include_trashed' => true,
    );
    
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
			'meta_keywords',
			'meta_data'
		);

	/**
	* Model Validation Rules
	*
	* @return array of rules used for input sanitation and model validation
	*/
	public $rules = array();

	public function user()
	{
		return $this->belongsTo('User');
	}

	public function scopeActivePosts($query)
	{
		$query->where('status',1);
	}
	//Return Post Resolved URL
	public function getPostUrlAttribute()
	{
		return route('slug', $this->slug);
	}
}