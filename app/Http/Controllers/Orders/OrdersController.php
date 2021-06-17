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
 | @package    App\Http\Controllers\Orders
 | @author     Swapnil Bhikule <bhikules@gmail.com>
 | @copyright  Open Source
 | @version    1.0
 | @date       15 Sept, 2019
 */

namespace App\Http\Controllers\Orders;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Repositories\Cart\CartRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\Order\OrderRepository;
use App\Repositories\OrderProductMap\OrderProductMapRepository;

/**
 * Class OrdersController
 *
 * @package App\Http\Controllers\Orders
 */
class OrdersController extends Controller
{
	/**
	 * @var OrderRepository
	 */
    protected $repository;
	/**
	 * @var UserRepository
	 */
    protected $user_repository;
	/**
	 * @var CartRepository
	 */
    protected $cart_repository;
	/**
	 * @var OrderProductMapRepository
	 */
    protected $order_product_map_repository;

	/**
	 * OrdersController constructor.
	 *
	 * @param UserRepository 			$user_repository
	 * @param CartRepository 			$cart_repository
	 * @param OrderRepository 			$repository
	 * @param OrderProductMapRepository $order_product_map_repository
	 */
    public function __construct(
    	UserRepository 				$user_repository,
		CartRepository 				$cart_repository,
		OrderRepository 			$repository,
		OrderProductMapRepository 	$order_product_map_repository
	) {
		$this->repository 					= $repository;
		$this->user_repository 				= $user_repository;
		$this->cart_repository 				= $cart_repository;
		$this->order_product_map_repository = $order_product_map_repository;
	}

	/**
	 * Store the order and its mapping to the database
	 *
	 * @param 	Request $request
	 * @return 	\Illuminate\Http\JsonResponse
	 * @throws 	\Illuminate\Validation\ValidationException
	 */
	public function store(Request $request) : \Illuminate\Http\JsonResponse
	{
		$this->validate($request, [
			'address.id' 		=> ['sometimes', 'required', 'integer'],
			'address.line_1' 	=> ['required', 'string', 'max:60'],
			'address.line_2' 	=> ['sometimes', 'required', 'string', 'max:60'],
			'address.state' 	=> ['required', 'string', 'max:60'],
			'address.country' 	=> ['required', 'string', 'max:100'],
			'address.post_code' => ['required', 'alpha_num'],
			'cart.*.id' 		=> ['required', 'integer', 'exists:carts,id']
		]);

		try {
			DB::beginTransaction();

			$this->updateAddress($request->input('address'));

			$cart_ids = array_column($request->input('cart'), 'id');

			$cart = $this->cart($cart_ids);

			if (! $cart) {
				return response()->json([
					'error' 	=> true,
					'message' 	=> 'Looks like your cart is empty. Please try adding products.'
				]);
			}

			$order = $this->repository->create([
				'order_id' 			=> uniqid('CEX-') . strtotime(now()),
				'user_id' 			=> auth()->user()->id,
				'payment_method_id' => $request->input('payment_method_id'),
				'status_id' 		=> 1,
				'total_price' 		=> $this->cartPrice($cart)
			]);

			$ordered_products = [];
			foreach ($cart as $item) {
				$ordered_products[] = [
					'order_id'   => $order->id,
					'product_id' => $item['product_id'],
					'quantity' 	 => $item['quantity'],
					'price' 	 => $item['product_price']
				];
			}

			$this->order_product_map_repository->bulkCreate($ordered_products);

			$this->deleteCart($cart_ids);

			DB::commit();

			return response()->json([
				'error' => false,
				'data' 	=> $order->toArray()
			]);
		} catch (\Exception $e) {
			DB::rollBack();

			return response()->json([
				'error' 	=> true,
				'message' 	=> 'Something went wrong while placing the order. Please try again later.'
			]);
		}
	}

	/**
	 * Return the cart details
	 *
	 * @param 	array $ids
	 * @return 	array
	 */
	private function cart(array $ids) : array
	{
		$cart = $this->cart_repository->products([
			['carts.id', 'IN', $ids]
		]);

		return $cart->toArray();
	}

	/**
	 * Deletes the card from the database
	 *
	 * @param 	array $ids
	 * @return 	bool|null
	 * @throws 	\Illuminate\Contracts\Container\BindingResolutionException
	 */
	private function deleteCart(array $ids)
	{
		return $this->cart_repository->bulkDelete([
			['id', 'IN', $ids]
		]);
	}

	/**
	 * Return total price of the cart
	 *
	 * @param 	$cart
	 * @return 	float|int
	 */
	private function cartPrice($cart)
	{
		return array_sum(array_column($cart, 'price'));
	}

	/**
	 * @param 	array $address
	 * @return 	mixed
	 */
	private function updateAddress(array $address)
	{
		return $this->user_repository->update(auth()->user()->id, [
			'address' => json_encode($address),
		]);
	}
}
