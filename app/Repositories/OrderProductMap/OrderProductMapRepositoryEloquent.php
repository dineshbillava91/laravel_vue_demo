<?php


namespace App\Repositories\OrderProductMap;

use App\Models\OrderProductMap;
use App\Repositories\BaseRepositoryEloquent;

class OrderProductMapRepositoryEloquent extends BaseRepositoryEloquent implements OrderProductMapRepository
{

	/**
	 * Specify Model class name
	 *
	 * @return string
	 */
	public function model() : string
	{
		return OrderProductMap::class;
	}
}
