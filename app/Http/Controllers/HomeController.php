<?php
/*
 |-------------------------------------------------------------
 | HomeController
 |-------------------------------------------------------------
 |
 | This controller returns the entry point for logged in user
 |
 | PHP version 7.2.3
 |
 |
 | @package    App\Http\Controllers
 | @author     Swapnil Bhikule <bhikules@gmail.com>
 | @copyright  Open Source
 | @version    1.0
 | @date       14 Sept, 2019
 */

namespace App\Http\Controllers;

/**
 * Class HomeController
 *
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        //
    }

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
    public function index()
    {
        return view('home');
    }
}
