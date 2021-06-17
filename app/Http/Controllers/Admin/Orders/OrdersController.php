<?php
/*
 |-------------------------------------------------------------
 | OrdersController
 |-------------------------------------------------------------
 |
 | This controller is responsible to perform CRUD operations on
 | orders, order_product_maps table
 |
 | PHP version 7.2.3
 |
 |
 | @package    App\Http\Controllers\Admin\Orders
 | @author     Swapnil Bhikule <bhikules@gmail.com>
 | @copyright  Open Source
 | @version    1.0
 | @date       14 Sept, 2019
 */

namespace App\Http\Controllers\Admin\Orders;

use App\Http\Controllers\Controller;

use App\Repositories\Order\OrderRepository;

/**
 * Class OrdersController
 *
 * @package App\Http\Controllers\Admin\Orders
 */
class OrdersController extends Controller
{
	/**
	 * @var OrderRepository
	 */
    protected $repository;

	/**
	 * OrdersController constructor.
	 *
	 * @param OrderRepository $repository
	 */
    public function __construct(OrderRepository $repository)
	{
		$this->repository = $repository;
	}

	/**
	 * Deletes the order
	 *
	 * @param 	int $id
	 * @return 	\Illuminate\Http\JsonResponse
	 */
	public function destroy(int $id) : \Illuminate\Http\JsonResponse
	{
		$flag = $this->repository->delete($id);

		return response()->json([
			'error' => ! $flag,
			'data' 	=> $flag
		]);
	}

	/**
	 * Return list of all orders
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Illuminate\Contracts\Container\BindingResolutionException
	 */
	public function all() : \Illuminate\Http\JsonResponse
	{
		$orders = $this->repository->all();

		return response()->json([
			'error' => false,
			'data' 	=> $orders->toArray()
		]);
	}
}
