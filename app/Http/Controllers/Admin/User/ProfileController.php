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
 | @package    App\Http\Controllers\Admin\User
 | @author     Swapnil Bhikule <bhikules@gmail.com>
 | @copyright  Open Source
 | @version    1.0
 | @date       14 Sept, 2019
 */

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;

/**
 * Class ProfileController
 *
 * @package App\Http\Controllers\Admin\User
 */
class ProfileController extends Controller
{
    public function __construct()
	{
		//
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
}
