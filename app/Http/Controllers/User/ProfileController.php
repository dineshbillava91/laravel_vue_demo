<?php
/*
 |-------------------------------------------------------------
 | ProfileController
 |-------------------------------------------------------------
 |
 | This controller is responsible to display authenticated user's
 | information
 |
 | PHP version 7.2.3
 |
 |
 | @package    App\Http\Controllers\User
 | @author     Swapnil Bhikule <bhikules@gmail.com>
 | @copyright  Open Source
 | @version    1.0
 | @date       14 Sept, 2019
 */

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepository;

/**
 * Class ProfileController
 *
 * @package App\Http\Controllers\User
 */
class ProfileController extends Controller
{
	/**
	 * @var UserRepository
	 */
	protected $repository;

	/**
	 * ProfileController constructor.
	 *
	 * @param UserRepository $repository
	 */
	public function __construct(UserRepository $repository)
	{
		$this->repository = $repository;
	}

	/**
	 * Return the authenticated user information
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getAuthenticatedUser() : \Illuminate\Http\JsonResponse
	{
		return response()->json([
			'error' => false,
			'data' 	=> [
				'name' => auth()->user()->name,
			]
		]);
	}

	/**
	 * Return user's address
	 *
	 * @return 	\Illuminate\Http\JsonResponse
	 * @throws 	\Illuminate\Contracts\Container\BindingResolutionException
	 */
	public function address() : \Illuminate\Http\JsonResponse
	{
		$address = $this->repository->find(auth()->user()->id, ['address']);

		return response()->json([
			'error' => false,
			'data' 	=> json_decode($address->address)
		]);
	}
}
