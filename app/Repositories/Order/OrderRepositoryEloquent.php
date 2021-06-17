<?php


namespace App\Repositories\Order;

use App\Models\Order;
use App\Repositories\BaseRepositoryEloquent;
use Illuminate\Support\Facades\DB;

class OrderRepositoryEloquent extends BaseRepositoryEloquent implements OrderRepository
{

	/**
	 * Specify Model class name
	 *
	 * @return string
	 */
	public function model() : string
	{
		return Order::class;
	}

	/**
	 * Return list of all orders
	 *
	 * @param 	array $columns
	 * @return 	mixed
	 */
	public function all($columns = array('*'))
	{
		return $this->model->select(
			'orders.id', 'orders.order_id', 'users.id AS user_id', 'users.name AS user_name', 'users.email AS user_email',
			'users.address AS user_address', DB::raw('SUM(order_product_maps.price*order_product_maps.quantity) AS price'),
			'statuses.status AS status_name', 'payment_methods.method AS payment_method', 'orders.created_at'
		)
			->join('order_product_maps', 'order_product_maps.order_id', '=', 'orders.id')
			->join('users', 'users.id', '=', 'orders.user_id')
			->join('payment_methods', 'payment_methods.id', '=', 'orders.payment_method_id')
			->join('statuses', 'statuses.id', '=', 'orders.status_id')
			->groupBy('orders.id')
			->get();

	}
}
