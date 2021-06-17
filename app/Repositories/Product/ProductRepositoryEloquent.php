<?php


namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\BaseRepositoryEloquent;

class ProductRepositoryEloquent extends BaseRepositoryEloquent implements ProductRepository
{
	/**
	 * Specify Model class name
	 *
	 * @return string
	 */
	public function model() : string
	{
		return Product::class;
	}

	/**
	 * Return list of all products
	 *
	 * @param 	array $columns
	 * @return 	mixed
	 */
	public function all($columns = array('*'))
	{
		return $this->model->select(
			'products.id', 'products.name', 'products.description', 'products.price', 'products.image',
			'categories.id AS category_id', 'categories.title AS category', 'products.created_at'
		)
			->leftJoin('categories', 'categories.id', '=', 'products.category_id')
			->get();
	}
}
