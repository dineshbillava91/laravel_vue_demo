<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProductMap extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'order_id', 'product_id', 'quantity', 'price'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function order() : \Illuminate\Database\Eloquent\Relations\BelongsTo
	{
		return $this->belongsTo(Order::class, 'order_id');
	}
}
