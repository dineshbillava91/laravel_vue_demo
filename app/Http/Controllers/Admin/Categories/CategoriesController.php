<?php
/*
 |-------------------------------------------------------------
 | CategoriesController
 |-------------------------------------------------------------
 |
 | This controller is responsible to perform CRUD operations on
 | categories table
 |
 | PHP version 7.2.3
 |
 |
 | @package    App\Http\Controllers\Admin\Categories
 | @author     Swapnil Bhikule <bhikules@gmail.com>
 | @copyright  Open Source
 | @version    1.0
 | @date       14 Sept, 2019
 */

namespace App\Http\Controllers\Admin\Categories;

use App\Traits\Category;
use Illuminate\Http\Request;
use App\Events\CategoryChanged;
use App\Http\Controllers\Controller;

use App\Repositories\Category\CategoryRepository;

/**
 * Class CategoriesController
 *
 * @package App\Http\Controllers\Admin\Categories
 */
class CategoriesController extends Controller
{
	use Category;

	/**
	 * @var CategoryRepository
	 */
	protected $repository;

	/**
	 * CategoriesController constructor.
	 *
	 * @param CategoryRepository $repository
	 */
    public function __construct(CategoryRepository $repository)
	{
		$this->repository = $repository;
	}

	/**
	 * Add new category to the database
	 *
	 * @param 	Request $request
	 * @return 	\Illuminate\Http\JsonResponse
	 * @throws 	\Illuminate\Validation\ValidationException
	 */
	public function store(Request $request) : \Illuminate\Http\JsonResponse
	{
		$this->validate($request, [
			'title' => ['required' ,'string', 'max:60']
		]);

		$category = $this->repository->create([
			'title' 	 => $request->input('title'),
			'created_by' => auth()->user()->id
		]);

		$category->created_by = auth()->user()->name;

		event(new CategoryChanged());

		if ($category) {
			return response()->json([
				'error' => false,
				'data' 	=> $category->toArray()
			]);
		}

		return response()->json([
			'error' 	=> true,
			'message' 	=> 'Internal server error occurred. Please try again later.'
		]);
	}

	/**
	 * Updates the given category
	 *
	 * @param 	Request $request
	 * @return 	\Illuminate\Http\JsonResponse
	 * @throws 	\Illuminate\Validation\ValidationException
	 */
	public function update(Request $request) : \Illuminate\Http\JsonResponse
	{
		$this->validate($request, [
			'id' 	=> ['required', 'integer', 'exists:categories,id'],
			'title' => ['required', 'string', 'max:60']
		]);

		$category = $this->repository->update($request->input('id'), [
			'title' => $request->input('title')
		]);

		event(new CategoryChanged());

		if ($category) {
			return response()->json([
				'error' => false,
				'data' 	=> $category->toArray()
			]);
		}

		return response()->json([
			'error'	 	=> true,
			'message' 	=> 'Internal server error occurred. Please try again later.'
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

		event(new CategoryChanged());

		return response()->json([
			'error' => ! $flag,
			'data' 	=> $flag
		]);
	}
}
