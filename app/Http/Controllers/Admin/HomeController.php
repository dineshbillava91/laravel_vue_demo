<?php
/*
 |-------------------------------------------------------------
 | HomeController
 |-------------------------------------------------------------
 |
 | This controller returns the entry point for logged in admin
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

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class HomeController
 *
 * @package App\Http\Controllers\Admin
 */
class HomeController extends Controller
{
    public function __construct()
    {
        //
    }

	/**
	 * Entry point of the admin dashboard
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
    public function index()
    {
        return view('admin.home');
    }


}
