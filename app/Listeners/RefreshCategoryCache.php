<?php

namespace App\Listeners;

use App\Events\CategoryChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Support\Facades\Cache;
use App\Repositories\Category\CategoryRepository;

class RefreshCategoryCache implements ShouldQueue
{
	/**
	 * @var CategoryRepository
	 */
	protected $repository;

    /**
     * Create the event listener.
     *
	 * @param 	CategoryRepository $repository
     * @return 	void
     */
    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the event.
     *
     * @param  CategoryChanged  $event
     * @return void
     */
    public function handle(CategoryChanged $event)
    {
    	Cache::forget('categories');
		Cache::rememberForever('categories', function () {
			return $this->repository->all();
		});
    }
}
