<?php


namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as Application;
use Illuminate\Contracts\Container\BindingResolutionException;

abstract class BaseRepositoryEloquent implements BaseRepository
{
	/**
	 * @var Application
	 */
	protected $app;
	/**
	 * @var Model
	 */
	protected $model;

	/**
	 * BaseRepositoryEloquent constructor.
	 *
	 * @param 	Application $app
	 * @throws 	BindingResolutionException
	 */
	public function __construct(Application $app)
	{
		$this->app = $app;

		$this->makeModel();
	}

	/**
	 * Specify Model class name
	 *
	 * @return string
	 */
	abstract public function model();

	/**
	 * Register Model class to our model parameter
	 *
	 * @return 	mixed
	 * @throws 	BindingResolutionException
	 */
	public function makeModel()
	{
		$model = $this->app->make($this->model());

		return $this->model = $model;
	}

	/**
	 * @throws BindingResolutionException
	 */
	public function resetModel()
	{
		$this->makeModel();
	}

	/**
	 * Retrieve all data of repository
	 *
	 * @param 	array $columns
	 * @return 	mixed
	 * @throws 	BindingResolutionException
	 */
	public function all($columns = array('*'))
	{
		if($this->model instanceof \Illuminate\Database\Eloquent\Builder){
			$results = $this->model->get($columns);
		} else {
			$results = $this->model->all($columns);
		}
		$this->resetModel();

		return $results;
	}

	/**
	 * Insert new row
	 *
	 * @param 	array $data
	 * @return 	mixed
	 * @throws 	BindingResolutionException
	 */
	public function create(array $data)
	{
		$model = $this->model->newInstance($data);
		$model->save();
		$this->resetModel();

		return $model;
	}

	/**
	 * Insert multiple rows
	 * @param 	array $data
	 * @return 	mixed
	 */
	public function bulkCreate(array $data)
	{
		return $this->model->insert($data);
	}

	/**
	 * Update the given row
	 *
	 * @param 	int $id
	 * @param 	array $data
	 * @return 	mixed
	 * @throws 	BindingResolutionException
	 */
	public function update(int $id, array $data)
	{
		$model = $this->model->findOrFail($id);
		$model->fill($data);
		$model->save();
		$this->resetModel();

		return $model;
	}

	/**
	 * Deletes the given row
	 *
	 * @param 	int $id
	 * @return 	mixed
	 * @throws 	BindingResolutionException
	 */
	public function delete(int $id)
	{
		$model = $this->model->find($id);
		$originalModel = clone $model;
		$this->resetModel();

		$deleted = $model->delete();

		return $deleted;
	}

	/**
	 * Delete multiple rows
	 *
	 * @param 	array $where
	 * @return 	bool|null
	 * @throws 	BindingResolutionException
	 */
	public function bulkDelete(array $where)
	{
		foreach($where as $field => $value)
		{
			if( is_array($value) )
			{
				list($field, $condition, $val) = $value;

				if ($condition === 'IN') {
					$this->model = $this->model->whereIn($field, $val);
				} else {
					$this->model = $this->model->where($field, $condition, $val);
				}
			}
			else
			{
				$this->model = $this->model->where($field,'=',$value);
			}
		}

		$model = $this->model->delete();
		$this->resetModel();

		return $model;
	}

	/**
	 * Find data by id
	 *
	 * @param 	int $id
	 * @param 	array $columns
	 * @return	 mixed
	 * @throws 	BindingResolutionException
	 */
	public function find(int $id, $columns = array('*'))
	{
		$model = $this->model->findOrFail($id, $columns);
		$this->resetModel();

		return $model;
	}

	/**
	 * Find data by field and value
	 *
	 * @param string $field
	 * @param $value
	 * @param array $columns
	 * @return mixed
	 * @throws 	BindingResolutionException
	 */
	public function findByField(string $field, $value = null, $columns = array('*'))
	{
		$model = $this->model->where($field,'=',$value)->get($columns);
		$this->resetModel();

		return $model;
	}

	/**
	 * Find data by multiple fields
	 *
	 * @param array $where
	 * @param array $columns
	 * @return mixed
	 * @throws 	BindingResolutionException
	 */
	public function findWhere(array $where , $columns = array('*'))
	{
		foreach($where as $field => $value)
		{
			if( is_array($value) )
			{
				list($field, $condition, $val) = $value;

				if ($condition === 'IN') {
					$this->model = $this->model->whereIn($field, $val);
				} else {
					$this->model = $this->model->where($field, $condition, $val);
				}
			}
			else
			{
				$this->model = $this->model->where($field,'=',$value);
			}
		}
		$model = $this->model->get($columns);
		$this->resetModel();

		return $model;
	}

	/**
	 * Find data by multiple values in one field
	 *
	 * @param 	$field
	 * @param 	array $values
	 * @param 	array $columns
	 * @return 	mixed
	 * @throws 	BindingResolutionException
	 */
	public function findWhereIn($field, array $values, $columns = ['*'])
	{
		$model = $this->model->whereIn($field, $values)->get($columns);
		$this->resetModel();

		return $model;
	}

	/**
	 * Load relations
	 *
	 * @param array|string $relations
	 * @return $this
	 */
	public function with($relations)
	{
		$this->model = $this->model->with($relations);
		return $this;
	}
}
