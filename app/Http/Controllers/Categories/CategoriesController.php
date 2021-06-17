<?php
/*
 |-------------------------------------------------------------
 | CategoriesController
 |-------------------------------------------------------------
 |
 | This controller is responsible to read required data from
 | categories table
 |
 | PHP version 7.2.3
 |
 |
 | @package    App\Http\Controllers\Categories
 | @author     Swapnil Bhikule <bhikules@gmail.com>
 | @copyright  Open Source
 | @version    1.0
 | @date       14 Sept, 2019
 */

namespace App\Http\Controllers\Categories;

use App\Traits\Category;
use App\Http\Controllers\Controller;

use App\Repositories\Category\CategoryRepository;

/**
 * Class CategoriesController
 *
 * @package App\Http\Controllers\Categories
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
}
