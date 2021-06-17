<?php


namespace App\Repositories\Cart;


use App\Repositories\BaseRepository;

interface CartRepository extends BaseRepository
{
	/**
	 * Return all products in given user's cart
	 *
	 * @param 	array $where
	 * @return 	mixed
	 */
	public function products(array $where);
}
