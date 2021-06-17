<?php


namespace App\Repositories;

use Illuminate\Contracts\Container\BindingResolutionException;

interface BaseRepository
{
	public function model();

	/**
	 * Register Model class to our model parameter
	 *
	 * @return 	mixed
	 * @throws 	BindingResolutionException
	 */
	public function makeModel();

	/**
	 * @throws BindingResolutionException
	 */
	public function resetModel();

	/**
	 * Retrieve all data of repository
	 *
	 * @param 	array $columns
	 * @return 	mixed
	 * @throws 	BindingResolutionException
	 */
	public function all($columns = array('*'));

	/**
	 * Insert new row in a categories table
	 *
	 * @param 	array $data
	 * @return 	mixed
	 */
	public function create(array $data);

	/**
	 * Insert multiple rows
	 * @param 	array $data
	 * @return 	mixed
	 */
	public function bulkCreate(array $data);

	/**
	 * Update the given row from categories table
	 *
	 * @param 	int $id
	 * @param 	array $data
	 * @return 	mixed
	 */
	public function update(int $id, array $data);

	/**
	 * Deletes the given row from categories table
	 *
	 * @param 	int $id
	 * @return 	mixed
	 */
	public function delete(int $id);

	/**
	 * Delete multiple rows
	 *
	 * @param 	array $where
	 * @return 	bool|null
	 * @throws 	BindingResolutionException
	 */
	public function bulkDelete(array $where);

	/**
	 * Find data by id
	 *
	 * @param 	int $id
	 * @param 	array $columns
	 * @return	 mixed
	 * @throws 	BindingResolutionException
	 */
	public function find(int $id, $columns = array('*'));

	/**
	 * Find data by field and value
	 *
	 * @param string $field
	 * @param $value
	 * @param array $columns
	 * @return mixed
	 * @throws 	BindingResolutionException
	 */
	public function findByField(string $field, $value = null, $columns = array('*'));

	/**
	 * Find data by multiple fields
	 *
	 * @param array $where
	 * @param array $columns
	 * @return mixed
	 * @throws 	BindingResolutionException
	 */
	public function findWhere(array $where , $columns = array('*'));

	/**
	 * Find data by multiple values in one field
	 *
	 * @param 	$field
	 * @param 	array $values
	 * @param 	array $columns
	 * @return 	mixed
	 * @throws 	BindingResolutionException
	 */
	public function findWhereIn($field, array $values, $columns = ['*']);

	/**
	 * Load relations
	 *
	 * @param array|string $relations
	 * @return $this
	 */
	public function with($relations);
}
