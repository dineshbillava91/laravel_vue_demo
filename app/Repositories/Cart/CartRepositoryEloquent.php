<?php


namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Repositories\BaseRepositoryEloquent;

class CartRepositoryEloquent extends BaseRepositoryEloquent implements CartRepository
{

	/**
	 * Specify Model class name
	 *
	 * @return string
	 */
	public function model() : string
	{
		return Cart::class;
	}

	/**
	 * Return all products in given user's cart
	 *
	 * @param 	array $where
	 * @return 	mixed
	 */
	public function products(array $where)
	{
		$query = $this->model->select(
			'carts.id', 'carts.quantity', 'products.id AS product_id', 'products.name AS product_name',
			'products.image AS product_image', 'products.price AS product_price'
		)
			->join('products', 'products.id', '=', 'carts.product_id')
			->join('users', 'users.id', '=', 'carts.user_id');

		foreach($where as $field => $value)
		{
			if( is_array($value) )
			{
				list($field, $condition, $val) = $value;

				if ($condition === 'IN') {
					$query = $query->whereIn($field, $val);
				} else {
					$query = $query->where($field, $condition, $val);
				}
			}
			else
			{
				$query = $query->where($field,'=',$value);
			}
		}

		return $query->get();
	}
}
