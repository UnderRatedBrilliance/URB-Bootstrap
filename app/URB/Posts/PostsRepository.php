<?php namespace URB\Posts;

use URB\Posts\Posts;
use URB\Core\EloquentRepository;

/**
* Posts Repository 
*/

class PostsRepository extends EloquentRepository
{
	
	public function __contstruct(Posts $model)
	{
		$this->model = $model;
	}

	
}