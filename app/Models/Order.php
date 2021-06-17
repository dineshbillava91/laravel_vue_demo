<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'order_id', 'user_id', 'payment_method_id', 'status_id', 'total_price'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function orderedProducts() : \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(OrderProductMap::class, 'order_id');
	}
}
