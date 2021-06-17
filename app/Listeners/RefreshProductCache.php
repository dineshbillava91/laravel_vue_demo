<?php

namespace App\Listeners;

use App\Events\ProductChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Support\Facades\Cache;
use App\Repositories\Product\ProductRepository;

class RefreshProductCache implements ShouldQueue
{
	protected $repository;

    /**
     * Create the event listener.
     *
	 * @param 	ProductRepository $repository
     * @return 	void
     */
    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the event.
     *
     * @param  ProductChanged  $event
     * @return void
     */
    public function handle(ProductChanged $event)
    {
    	Cache::forget('admin-products');
		Cache::rememberForever('admin-products', function () {
			return $this->repository->all();
		});
    }
}
