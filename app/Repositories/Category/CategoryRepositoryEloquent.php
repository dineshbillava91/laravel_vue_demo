<?php


namespace App\Repositories\Category;

use App\Models\Category;
use App\Repositories\BaseRepositoryEloquent;

class CategoryRepositoryEloquent extends BaseRepositoryEloquent implements CategoryRepository
{
	/**
	 * Specify Model class name
	 *
	 * @return string
	 */
	public function model() : string
	{
		return Category::class;
	}

	/**
	 * Return list of all categories
	 *
	 * @param 	array $columns
	 * @return 	Category[]|\Illuminate\Database\Eloquent\Collection
	 */
	public function all($columns = array('*'))
	{
		return $this->model->select(
			'categories.id', 'categories.title', 'categories.created_at'
		)
			->get();
	}
}
