<?php
/*
 |-------------------------------------------------------------
 | ProductsController
 |-------------------------------------------------------------
 |
 | This controller is responsible to perform CRUD operations on
 | products table
 |
 | PHP version 7.2.3
 |
 |
 | @package    App\Http\Controllers\Admin\Products
 | @author     Swapnil Bhikule <bhikules@gmail.com>
 | @copyright  Open Source
 | @version    1.0
 | @date       14 Sept, 2019
 */

namespace App\Http\Controllers\Admin\Products;

use Illuminate\Http\Request;
use App\Events\ProductChanged;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

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
	 * Add new product to the database
	 *
	 * @param 	Request $request
	 * @return 	\Illuminate\Http\JsonResponse
	 * @throws 	\Illuminate\Validation\ValidationException
	 */
	public function store(Request $request) : \Illuminate\Http\JsonResponse
	{
		$this->validate($request, [
			'name' 			=> ['required' ,'string', 'max:60'],
			'description' 	=> ['required', 'string'],
			'category_id' 	=> ['required', 'integer', 'exists:categories,id'],
			'image' 		=> ['required', 'base64image'],
			'price' 		=> ['required', 'numeric']
		]);

		if (preg_match('/^data:image\/(\w+);base64,/', $request->input('image'))) {
			$path = $this->saveProductImage($request->input('image'));
		} else {
			return redirect()->back([
				'error' 	=> true,
				'message' 	=> 'Please try uploading a valid image'
			]);
		}

		$product = $this->repository->create([
			'category_id' 	=> $request->input('category_id'),
			'name' 			=> $request->input('name'),
			'description' 	=> $request->input('description'),
			'price' 		=> $request->input('price'),
			'image' 		=> $path
		]);

		$product->category_id 	= $request->input('category_id');
		$product->category 		= $request->input('category');

		event(new ProductChanged());

		if ($product) {
			return response()->json([
				'error' => false,
				'data' 	=> $product->toArray()
			]);
		}

		return response()->json([
			'error' 	=> true,
			'message' 	=> 'Internal server error occurred. Please try again later.'
		]);
	}

	/**
	 * Updates the given product
	 *
	 * @param 	Request $request
	 * @return 	\Illuminate\Http\JsonResponse
	 * @throws 	\Illuminate\Validation\ValidationException
	 */
	public function update(Request $request) : \Illuminate\Http\JsonResponse
	{
		$this->validate($request, [
			'id' 			=> ['required', 'integer', 'exists:products,id'],
			'name' 			=> ['required' ,'string', 'max:60'],
			'description' 	=> ['required', 'string'],
			'category_id' 	=> ['required', 'integer', 'exists:categories,id'],
			'image' 		=> ['nullable', 'base64image'],
			'price' 		=> ['required', 'numeric']
		]);

		$path = '';
		if ($request->has('image') && preg_match('/^data:image\/(\w+);base64,/', $request->input('image'))) {
			$path = $this->saveProductImage($request->input('image'));
		}

		$data = [
			'category_id' 	=> $request->input('category_id'),
			'name' 			=> $request->input('name'),
			'description' 	=> $request->input('description'),
			'price' 		=> $request->input('price'),
		];

		$path ? $data['image'] = $path : null;

		$product = $this->repository->update($request->input('id'), $data);

		$product->category = $request->input('category');

		event(new ProductChanged());

		if ($product) {
			return response()->json([
				'error' => false,
				'data' 	=> $product->toArray()
			]);
		}

		return response()->json([
			'error' 	=> true,
			'message' 	=> 'Internal server error occurred. Please try again later.'
		]);
	}

	/**
	 * Deletes the product from database
	 *
	 * @param 	int $id
	 * @return 	\Illuminate\Http\JsonResponse
	 */
	public function destroy(int $id) : \Illuminate\Http\JsonResponse
	{
		$flag = $this->repository->delete($id);

		event(new ProductChanged());

		return response()->json([
			'error' => ! $flag,
			'data' 	=> $flag
		]);
	}

	/**
	 * Return list of all products from the collection
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Illuminate\Contracts\Container\BindingResolutionException
	 */
	public function all() : \Illuminate\Http\JsonResponse
	{
		$products = Cache::rememberForever('admin-products', function () {
			return $this->repository->all();
		});

		return response()->json([
			'error' => false,
			'data' 	=> $products->toArray()
		]);
	}

	/**
	 * Saves the image to local disk
	 *
	 * @param 	string $image
	 * @return 	string
	 */
	private function saveProductImage(string $image) : string
	{
		$data = substr($image, strpos($image, ',') + 1);
		$data = base64_decode($data);
		$path = '/content/' . uniqid('product-') . ".png";

		Storage::disk('public')->put($path, $data);

		return $path;
	}
}
