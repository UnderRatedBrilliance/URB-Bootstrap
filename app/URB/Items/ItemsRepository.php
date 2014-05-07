<?php namespace URB\Items;

use URB\Items\Items;
use URB\Core\VocalRepository;

/**
* Items Repository 
*/

class ItemsRepository extends VocalRepository
{
	
	public function __contstruct(Items $model)
	{
		$this->model = $model;
	}

	/**
	* Get all Items and return results Paginated
	* @var int $paginated
	* @return \URB\Items\Items
	*/
	public function getItemsPaginated($paginated = 20)
	{
		return $this->getAllPaginated($paginated);
	}

	/**
	* Find item by Id
	* @var int $id
	* @return \URB\Items\Items
	*/
	public function getItemById($id)
	{
		return $this->model->find($id);
	}

	/**
	* Return Items filter by array of values and sortBy given column
	* @var array $filters - Column values
	* @var mixed $sortBy - accepts string or array - example array('id'=>'asc','name'=>'asc')
	* @return \URB\Items\Items
	*/
	public function filterItemsBy(array $filters = array(),$sortBy = 'id',$paginate = 20)
	{
		return $this->model->FilterAndSortBy($filters,$sortBy)->paginate($paginate);
	}

	
}