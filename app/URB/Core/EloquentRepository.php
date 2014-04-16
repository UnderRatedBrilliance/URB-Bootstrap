<?php namespace URB\Core;

use Illuminate\Database\Eloquent\Model;
use URB\Core\Interfaces\BaseRepositoryInterface;

abstract class EloquentRepository implements BaseRepositoryInterface
{

	public function __construct($model = null)
	{
		$this->model = $model;
	}

	public function getModel()
	{
		return $this->model;
	}

	public function setModel($model)
	{
		$this->model = $model;
	}

	public function getAll()
	{
		return $this->model->all();
	}

	public function getAllPaginated($count = 20)
	{
		return $this->model->paginate($count);
	}

	public function find($id)
	{
		return $this->model->find($id);
	}

	// Find with model relations
	public function findWith($id, array $with)
	{
		return $this->model->with($with)->find($id);
	}

	 public function getNew($attributes = array())
    {
        return $this->model->newInstance($attributes);
    }

    public function save($data)
    {
        if ($data instanceOf Model) {
            return $this->storeEloquentModel($data);
        } elseif (is_array($data)) {
            return $this->storeArray($data);
        }
    }

    public function delete($model)
    {
        return $model->delete();
    }

    protected function storeEloquentModel($model)
    {
        if ($model->getDirty()) {
            return $model->save();
        } else {
            return $model->touch();
        }
    }

    protected function storeArray($data)
    {
        $model = $this->getNew($data);
        return $this->storeEloquentModel($model);
    }

}