<?php namespace URB\Core\Interfaces;

interface BaseRepositoryInterface 
{
	
	public function getModel();

	public function setModel($model);

	public function getAll();

	public function getAllPaginated($count);

	public function find($id);

	public function save($data);

	public function delete($model);



}