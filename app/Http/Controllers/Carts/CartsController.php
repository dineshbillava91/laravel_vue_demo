<?php
/*
 |-------------------------------------------------------------
 | CartsController
 |-------------------------------------------------------------
 |
 | This controller is responsible to perform CRUD operations on
 | carts table
 |
 | PHP version 7.2.3
 |
 |
 | @package    App\Http\Controllers\Carts
 | @author     Swapnil Bhikule <bhikules@gmail.com>
 | @copyright  Open Source
 | @version    1.0
 | @date       15 Sept, 2019
 */

namespace App\Http\Controllers\Carts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\Cart\CartRepository;

/**
 * Class CartsController
 *
 * @package App\Http\Controllers\Carts
 */
class CartsController extends Controller
{
	/**
	 * @var CartRepository
	 */
	protected $repository;

	/**
	 * CartsController constructor.
	 *
	 * @param CartRepository $repository
	 */
    public function __construct(CartRepository $repository)
	{
		$this->repository = $repository;
	}

	/**
	 * @param 	Request $request
	 * @return 	\Illuminate\Http\JsonResponse
	 * @throws 	\Illuminate\Contracts\Container\BindingResolutionException
	 * @throws 	\Illuminate\Validation\ValidationException
	 */
	public function addItemToCart(Request $request)
	{
		$this->validate($request, [
			'product_id' 	=> ['required', 'integer' ,'exists:products,id'],
			'quantity' 		=> ['required', 'integer']
		]);

		$item = $this->repository->findWhere([
			'user_id' 	 => auth()->user()->id,
			'product_id' => $request->input('product_id')
		]);

		if ($item->isEmpty()) {
			$cart = $this->repository->create([
				'user_id' 	 => auth()->user()->id,
				'product_id' => $request->input('product_id'),
				'quantity' 	 => $request->input('quantity')
			]);
		} else {
			$quantity = $item[0]->quantity + $request->input('quantity');

			$cart = $this->repository->update($item[0]->id, [
				'quantity' => $quantity
			]);
		}

		$cart = $this->repository->products([
			'carts.id' => $cart->id
		]);

		return response()->json([
			'error' => false,
			'data' 	=> $cart[0]
		]);
	}

	/**
	 * Deletes the category from database
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
	 * Return the logged in user's cart
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function all()
	{
		$cart = $this->repository->products([
			'user_id' => auth()->user()->id
		]);

		return response()->json([
			'error' => false,
			'data' 	=> $cart->toArray()
		]);
	}
}
