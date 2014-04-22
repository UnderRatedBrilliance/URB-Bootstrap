<?php namespace URB\Posts;

use URB\Posts\Posts;
use URB\Core\VocalRepository;

/**
* Posts Repository 
*/

class PostsRepository extends VocalRepository
{
	
	public function __contstruct(Posts $model)
	{
		$this->model = $model;
	}

	public function getActivePosts($paginated = 20)
	{
		return $this->model->where('status',1)->
	}
}