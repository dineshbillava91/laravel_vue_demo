<?php


namespace App\Traits;

use Illuminate\Support\Facades\Cache;

/**
 * Trait Category
 *
 * @package App\Traits
 */
trait Category
{
	/**
	 * Return list of all categories from the collection
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function all() : \Illuminate\Http\JsonResponse
	{
		$categories = Cache::rememberForever('categories', function () {
			return $this->repository->all();
		});

		return response()->json([
			'error' => false,
			'data' 	=> $categories->toArray()
		]);
	}
}
