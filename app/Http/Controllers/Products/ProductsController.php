<?php
/*
 |-------------------------------------------------------------
 | ProductsController
 |-------------------------------------------------------------
 |
 | This controller is responsible to display list of products
 |
 | PHP version 7.2.3
 |
 |
 | @package    App\Http\Controllers\Products
 | @author     Swapnil Bhikule <bhikules@gmail.com>
 | @copyright  Open Source
 | @version    1.0
 | @date       14 Sept, 2019
 */

namespace App\Http\Controllers\Products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\Product\ProductRepository;

/**
 * Class ProductsController
 *
 * @package App\Http\Controllers\Admin\Products
 */
class ProductsController extends Controller
{
	/**
	 * @var ProductRepository
	 */
	protected $repository;

	/**
	 * ProductsController constructor.
	 *
	 * @param ProductRepository $repository
	 */
	public function __construct(ProductRepository $repository)
	{
		$this->repository = $repository;
	}

	/**
	 * Return list of all products from the collection
	 *
	 * @param 	Request $request
	 * @return 	\Illuminate\Http\JsonResponse
	 * @throws 	\Illuminate\Contracts\Container\BindingResolutionException
	 * @throws 	\Illuminate\Validation\ValidationException
	 */
	public function all(Request $request) : \Illuminate\Http\JsonResponse
	{
		$this->validate($request, [
			'category' => ['sometimes', 'required', 'integer', 'exists:categories,id']
		]);

		if ($request->all()) {
			$filters = [];

			$request->has('category') ? $filters['category_id'] = $request->input('category') : null;

			$products = $this->repository->findWhere($filters);
		} else {
			$products = $this->repository->all();
		}

		return response()->json([
			'error' => false,
			'data'  => $products->toArray()
		]);
	}
}
