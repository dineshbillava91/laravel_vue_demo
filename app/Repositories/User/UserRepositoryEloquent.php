<?php


namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepositoryEloquent;

class UserRepositoryEloquent extends BaseRepositoryEloquent implements UserRepository
{
	/**
	 * Specify Model class name
	 *
	 * @return string
	 */
	public function model() : string
	{
		return User::class;
	}
}
